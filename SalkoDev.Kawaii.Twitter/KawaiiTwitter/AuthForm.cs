using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace SalkoDev.KawaiiTwitter
{
	public partial class AuthForm : Form
	{
		public AuthForm()
		{
			InitializeComponent();
		}

		/// <summary>
		/// Авторизационный URL, который нужно отобразить на странице
		/// </summary>
		public string AuthURL
		{
			get;
			set;
		}

		/// <summary>
		/// Код авторизации который нужно использовать далее
		/// </summary>
		public string AuthCode
		{
			get;
			set;
		}

		private void AuthForm_Load(object sender, EventArgs e)
		{
			if (!string.IsNullOrEmpty(AuthURL))
			{
				_WebBrowser.Navigate(AuthURL);
			}
		}
				
		private void _ButtonClose_Click(object sender, EventArgs e)
		{
			//извлечем из браузера код , который нам нужен
			string html = _WebBrowser.DocumentText.ToLower();
			string codePart1="<code>";
			string codePart2="</code>";
			int ind1=html.IndexOf(codePart1);
			int ind2=html.IndexOf(codePart2);

			//<code>12567</code>
			if(ind1>=0 && ind2>=0 && ind2>ind1)
			{
				string code = html.Substring(ind1 + codePart1.Length, ind2 - ind1 - codePart1.Length);
				AuthCode = code;
			}
		}
	}
}
