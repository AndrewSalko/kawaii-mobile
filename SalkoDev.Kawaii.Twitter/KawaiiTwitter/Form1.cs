using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;
using TweetSharp;
using System.IO;
using System.Data.SQLite;
using System.Reflection;

namespace SalkoDev.KawaiiTwitter
{
	public partial class Form1 : Form, ILog, IMain
	{
		public Form1()
		{
			InitializeComponent();
		}

		Service _Service;

		public Service TwitterService
		{
			get
			{
				return _Service;
			}
		}
				
		private void exitToolStripMenuItem_Click(object sender, EventArgs e)
		{
			Close();
		}

		#region _Auth
		bool _Auth()
		{
			bool result = false;

			try
			{
				if (_Service != null)
					return true;//уже подключены

				TwitterService service = new TwitterService("TWsI4KPPYv8wWwhYBcw", "960jnQYjQo5oSW4aPrUxYhEJZg8yGHzXo5OBzQk3Ig");

				// Step 1 - Retrieve an OAuth Request Token
				OAuthRequestToken requestToken = service.GetRequestToken();

				// Step 2 - Redirect to the OAuth Authorization URL
				Uri uri = service.GetAuthorizationUri(requestToken);

				string url = uri.ToString();
				AuthForm authForm = new AuthForm();
				authForm.AuthURL = url;
				authForm.ShowDialog(this);

				string verifier = authForm.AuthCode;

				OAuthAccessToken access = service.GetAccessToken(requestToken, verifier);
				if (access.UserId == 0)
				{
					MessageBox.Show(this, "Authorization failed!", Text, MessageBoxButtons.OK, MessageBoxIcon.Exclamation);
					return result;
				}

				// Step 4 - User authenticates using the Access Token
				service.AuthenticateWith(access.Token, access.TokenSecret);
				_Service = new Service(service);

				result = true;
			}
			catch (Exception ex)
			{
				_Service = null;
				MessageBox.Show(this, ex.Message, "Error", MessageBoxButtons.OK, MessageBoxIcon.Error);
			}

			return result;
		}
		#endregion

		public void Log(string format, params object[] args)
		{
			string msg = string.Format(format, args);

			if(InvokeRequired)
			{
				this.Invoke((MethodInvoker)delegate
				{
					int ind = _ListBoxLog.Items.Add(msg);
					_ListBoxLog.SelectedIndex = ind;
				});
			}
			else
			{
				int ind = _ListBoxLog.Items.Add(msg);
				_ListBoxLog.SelectedIndex = ind;
			}
		}

		private void _ConnectToolStripMenuItem_Click(object sender, EventArgs e)
		{
			_Auth();
		}

		void _ShowMessage(string text, MessageBoxIcon icon)
		{
			MessageBox.Show(this, text, this.Text, MessageBoxButtons.OK, icon);
		}
	}
}
