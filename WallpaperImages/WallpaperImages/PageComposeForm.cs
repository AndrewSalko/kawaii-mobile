using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace WallpaperImages
{
	public partial class PageComposeForm : Form
	{
		public PageComposeForm()
		{
			InitializeComponent();
		}

		PageCompose _PageCompose;

		public string AnimeName
		{
			get;
			set;
		}

		private void PageComposeForm_Load(object sender, EventArgs e)
		{
			_CheckedListBoxResolutions.Items.Clear();

			_PageCompose = new PageCompose(AnimeName);

			string[] resolutions = _PageCompose.Resolutions;
			if (resolutions != null)
			{
				for(int i=0; i<resolutions.Length;i++)
				{
					_CheckedListBoxResolutions.Items.Add(resolutions[i], false);
				}
			}

		}

		void _UpdateHTMLBody()
		{			
			SortedDictionary<int, string> dictSortedResolutAndroid = new SortedDictionary<int, string>(new ReverseComparer<int>());
			SortedDictionary<int, string> dictSortedResolut = new SortedDictionary<int, string>(new ReverseComparer<int>());

			foreach (var item in _CheckedListBoxResolutions.CheckedItems)
			{
				string resolut = item.ToString();
				string[] parts=resolut.Split('x');
				int width=int.Parse(parts[0]);				
				int height = int.Parse(parts[1]);

				int mult = width * height;

				if (width > height)
				{
					//разрешения для Андроид идут первыми
					dictSortedResolutAndroid[mult] = resolut;
				}
				else
				{
					dictSortedResolut[mult] = resolut;				
				}				
			}

			List<string> resultResolutions = new List<string>();
			foreach (var item in dictSortedResolutAndroid)
			{
				resultResolutions.Add(item.Value);
			}
			foreach (var item in dictSortedResolut)
			{
				resultResolutions.Add(item.Value);
			}

			//теперь подготовим "результат" - HTML-документ:
			_TextBoxPage.Text = _PageCompose.GetHTML(resultResolutions.ToArray(), _TextBoxWiki.Text, _TextBoxGenre.Text, _CheckBoxTable.Checked, _CheckBoxReview.Checked);
		}

		private void _CheckedListBoxResolutions_KeyUp(object sender, KeyEventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _CheckedListBoxResolutions_MouseUp(object sender, MouseEventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _CheckedListBoxResolutions_ItemCheck(object sender, ItemCheckEventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _TextBoxWiki_TextChanged(object sender, EventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _TextBoxGenre_TextChanged(object sender, EventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _CheckBoxTable_CheckedChanged(object sender, EventArgs e)
		{
			_UpdateHTMLBody();
		}

		private void _CheckBoxReview_CheckedChanged(object sender, EventArgs e)
		{
			_UpdateHTMLBody();
		}
	}
}
