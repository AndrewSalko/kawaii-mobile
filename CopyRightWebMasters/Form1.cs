using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using System.IO;
using System.Text.RegularExpressions;

namespace CopyRightWebMasters
{
	public partial class Form1 : Form
	{
		public Form1()
		{
			InitializeComponent();
		}

		private void _ButtonStart_Click(object sender, EventArgs e)
		{
			//target="_blank">http://kawaii-mobile.com/2016/01/photo-kano/</a>

			string srcFileName = Path.Combine(Application.StartupPath, "source.htm");
			
			if(!File.Exists(srcFileName))
			{
				MessageBox.Show(this, "Файл " + srcFileName + " не найден", "Файл исходных данных не найден", MessageBoxButtons.OK, MessageBoxIcon.Information);
				return;
			}

			string allText = File.ReadAllText(srcFileName);

			string firstBlock = "break-all;\" target=\"_blank\">";
			string lastBlock = "</a>";
			string pattern = firstBlock + "(.*?)" + lastBlock;

			List<string> resultURLs = new List<string>();

			Regex rg = new Regex(pattern);
			MatchCollection matches = rg.Matches(allText);
			if (matches != null)
			{
				for (int i = 0; i < matches.Count; i++)
				{
					Match m = matches[i];
					string result = m.Value;

					if (string.IsNullOrWhiteSpace(result))
						continue;

					result= result.Replace(lastBlock, string.Empty);
					result = result.Replace(firstBlock, string.Empty);

					string url = string.Format("\"{0}\"", result);
					resultURLs.Add(url);
				}
			}

			string resFileName = Path.Combine(Application.StartupPath, "result.txt");

			using (var resFile = File.CreateText(resFileName))
			{
				//теперь делаем для массива:			
				for (int j = 0; j < resultURLs.Count; j++)
				{
					string resLine = resultURLs[j];

					if (j != resultURLs.Count - 1)
					{
						resLine += ",";
					}

					resFile.WriteLine(resLine);
				}
			}

			MessageBox.Show(this, "Done", "Done", MessageBoxButtons.OK, MessageBoxIcon.Information);
		}
	}
}
