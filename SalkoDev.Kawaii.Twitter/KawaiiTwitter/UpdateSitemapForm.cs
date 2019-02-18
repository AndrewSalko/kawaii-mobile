using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.IO;
using System.Linq;
using System.Net;
using System.Text;
using System.Windows.Forms;

namespace SalkoDev.KawaiiTwitter
{
	public partial class UpdateSitemapForm : Form, ILog
	{
		public UpdateSitemapForm()
		{
			InitializeComponent();
		}
				
		internal Sitemap.SitePageData Data
		{
			get;
			set;
		}

		private void _BackgroundWorker_DoWork(object sender, DoWorkEventArgs e)
		{
			UpdateSitemapArgs args = (UpdateSitemapArgs)e.Argument;

			string url = args.URL;
			int limitCount = args.LimitPagesCount;

			string fileNameSitemap = null;
			try
			{
				//загрузить (скачать) с сервера sitemap - XML
				var req = WebRequest.Create(url);
				using (var resp = req.GetResponse())
				{
					using (var srcStream = resp.GetResponseStream())
					{
						fileNameSitemap = Path.GetTempFileName() + ".sitemap.xml";

						using (var dstStream = File.Create(fileNameSitemap))
						{
							Templates.IO.StreamCopy.Copy(srcStream, dstStream);
						}
					}
				}

				Sitemap.SitemapLoader loader = new Sitemap.SitemapLoader(fileNameSitemap);
				loader.LimitCount = limitCount;
				loader.DelayIntervalTitleRequest = 1000;
				loader.DoWork(_BackgroundWorker, this);

				if (_BackgroundWorker.CancellationPending)
					return;

				//теперь добавим все в базу
				var foundPages = loader.Pages;
				if (foundPages == null || foundPages.Length == 0)
					return;

				foreach (var pg in foundPages)
				{
					//проверим, для каждой страницы есть ли она такая уже, если нет - добавим
					//TODO@: пока не учитываем "обновление" оно не критично

					var foundInDB = (from page in Data.Pages where page.URL == pg.URL select page).ToArray();
					if (foundInDB == null || foundInDB.Length == 0)
					{
						//нет такой в базе, добавляем
						Data.Pages.InsertOnSubmit(pg);
						Data.SubmitChanges();
					}

					if (_BackgroundWorker.CancellationPending)
						return;

				}//foreach

			}
			finally
			{
				if (fileNameSitemap != null)
				{
					File.Delete(fileNameSitemap);
				}
			}

		}

		private void _BackgroundWorker_RunWorkerCompleted(object sender, RunWorkerCompletedEventArgs e)
		{
			_ButtonCancel.Text = "Закрити";

			if (e.Cancelled)
			{
				//если процесс успешен то снова видеть кнопку "ОК" нам не нужно
				_ButtonOK.Enabled = true;
			}

			if (e.Error != null)
			{
				MessageBox.Show(this, e.Error.ToString(), e.Error.Message, MessageBoxButtons.OK, MessageBoxIcon.Error);
			}
			else
			{
				DialogResult = DialogResult.Cancel;
				Close();
			}
		}

		public void Log(string format, params object[] args)
		{
			string msg = string.Format(format, args);

			if (InvokeRequired)
			{
				this.Invoke((MethodInvoker)delegate
				{
					_LabelProgress.Text = msg;
				});
			}
			else
			{
				_LabelProgress.Text = msg;
			}
		}

		private void _ButtonOK_Click(object sender, EventArgs e)
		{
			if (_BackgroundWorker.IsBusy)
			{
				MessageBox.Show(this, "Процес ще не завершено", "Помилка запуску", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
				return;
			}

			int limitCount = 0;

			if (_CheckBoxLimit.Checked)
			{
				string textLimit = _TextBoxLimitCount.Text;
				if (!int.TryParse(textLimit, out limitCount))
				{
					MessageBox.Show(this, "Невірно вказано ліміт", "Помилка запуску", MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
					return;
				}
			}

			UpdateSitemapArgs args = new UpdateSitemapArgs
			{
				URL = _TextBoxURL.Text,
				LimitPagesCount = limitCount
			};

			_ButtonOK.Enabled = false;

			_BackgroundWorker.RunWorkerAsync(args);
		}

		private void UpdateSitemapForm_FormClosing(object sender, FormClosingEventArgs e)
		{
			if (_BackgroundWorker.IsBusy)
			{
				_BackgroundWorker.CancelAsync();
			}
		}

		private void UpdateSitemapForm_Load(object sender, EventArgs e)
		{
			_LabelProgress.Text = string.Empty;
		}
	}
}
