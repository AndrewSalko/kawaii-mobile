using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Text;
using System.Windows.Forms;
using System.IO;

namespace WallpaperImages
{
	public partial class Form1 : Form
	{
		public Form1()
		{
			InitializeComponent();
		}

		Random _Rnd = new Random(Environment.TickCount);

		PhonePromo _PhonePromo = new PhonePromo();

		private void _ButtonOpenFiles_Click(object sender, EventArgs e)
		{
			if (openFileDialog1.ShowDialog() == DialogResult.OK)
			{
				string[] fileNames = openFileDialog1.FileNames;
				_ListBoxFiles.BeginUpdate();
				for (int i = 0; i < fileNames.Length; i++)
				{
					ImageFile imgFile = new ImageFile(fileNames[i]);
					_ListBoxFiles.Items.Add(imgFile);
				}
				_ListBoxFiles.EndUpdate();				
			}
		}

		///// <summary>
		///// Имя аниме.320x480.jpg
		///// </summary>
		//string _PATTERN_SIMPLE = "{0}.{1}x{2}{3}";
		//string _PATTERN_SIMPLE_COUNTER = "{0}.{1}x{2} ({3}){4}";

		//string _PATTERN_CHAR_NAMES = "{0}.{3}.{1}x{2}{4}";		
		//string _PATTERN_CHAR_NAMES_COUNTER = "{0}.{3}.{1}x{2} ({4}){5}";

		//Dictionary<string, Size> 

		string _ComposeNewFileName(string sourceFileName, string directoryName)
		{
			string charNames=string.Empty;
			bool useRandomPhoneName = _CheckBoxAddPhoneName.Checked;

			int dimX = _PictureBox.Image.Width;
			int dimY = _PictureBox.Image.Height;
			
			List<string> charNamesList = new List<string>();			
			for (int i = 0; i < _CheckedListBoxNameOfCharacters.Items.Count; i++)
			{
				bool checkedItem = _CheckedListBoxNameOfCharacters.GetItemChecked(i);
				if (checkedItem)
				{
					string charName = _CheckedListBoxNameOfCharacters.Items[i].ToString();
					charNamesList.Add(charName);
				}
			}

			string phonePromoText = string.Empty;
			if (useRandomPhoneName)
			{
				phonePromoText = _PhonePromo.GetPhonePromoText(new Size(dimX, dimY));
			}

			//if (charNamesList.Count > 0)
			//{
			//	int indexPhonePromo = _Rnd.Next(0, charNamesList.Count);

			//	for (int i = 0; i < charNamesList.Count; i++)
			//	{
			//		string charName = charNamesList[i];
			//		charNames += charName;

			//		if (useRandomPhoneName && indexPhonePromo == i)
			//		{						
			//			charNames += " ";
			//			charNames += phonePromoText;
			//			charNames += ".";

			//			phonePromoText = string.Empty;//очистим, чтобы ниже не добавлять еще раз
			//		}
			//		else
			//		{
			//			charNames += ".";
			//		}
			//	}
			//}

			//charNames = charNames.Trim('.');
			charNames = string.Join(" ", charNamesList.ToArray());
			
			string ext = System.IO.Path.GetExtension(sourceFileName);

			bool fileNameNotAvailable = false;
			string result = null;
			int counter = 0;
			do
			{
				result = _TextBoxNameOfAnime.Text;//имя аниме идет первым в любом случае

				//если есть имена - добавляем их сразу:
				if (!string.IsNullOrEmpty(charNames))
				{
					result += " "+charNames;
				}

				if (!string.IsNullOrEmpty(phonePromoText))
				{
					result += "." + phonePromoText;
				}

				//после имен - добавляем "разрешение экрана"
				result += string.Format(" {0}x{1}", dimX,dimY);//добавляем 320x480

				if (counter > 0)
				{
					result += string.Format(" ({0})", counter);
				}			
				
				//последниим идет расширение
				result += ext;
				
				string fullNameNew = System.IO.Path.Combine(directoryName, result);
				fileNameNotAvailable = File.Exists(fullNameNew);
				counter++;

			} while (fileNameNotAvailable);
			
			return result;
		}

		ImageFile _GetSelectedFile()
		{
			ImageFile result = null;
			//берем текущий файл:
			if (_ListBoxFiles.SelectedIndex < 0)
			{
				return result;
			}
			result = (ImageFile)_ListBoxFiles.SelectedItem;
			return result;
		}

		void _UpdateNewName()
		{
			ImageFile file=_GetSelectedFile();
			if (file == null)
			{
				return;
			}

			string currentFileName = file.Name;
			string directory = System.IO.Path.GetDirectoryName(file.FullName);

			string newName = _ComposeNewFileName(currentFileName, directory);
			_TextBoxNewFileName.Text = newName;
		}

		private void _ListBoxFiles_SelectedIndexChanged(object sender, EventArgs e)
		{
			ImageFile file = _GetSelectedFile();
			if (file == null)
			{
				return;
			}

			using (var fs = new System.IO.FileStream(file.FullName, FileMode.Open, FileAccess.Read))
			{
				_PictureBox.Image = Image.FromStream(fs);
			}
			
			//_PictureBox.Load(file.FullName);	
			
			_UpdateNewName();
		}

		private void _CheckedListBoxNameOfCharacters_ItemCheck(object sender, ItemCheckEventArgs e)
		{
			_UpdateNewName();
		}

		bool _InTextChanged = false;

		private void _TextBoxNameOfAnime_TextChanged(object sender, EventArgs e)
		{
			if (_InTextChanged)
				return;

			_InTextChanged = true;
			try
			{
				string name = _TextBoxNameOfAnime.Text;
				string nameNew = name.Trim('"');
				if (nameNew != name)
					_TextBoxNameOfAnime.Text = nameNew;
			}
			finally
			{
				_InTextChanged = false;
			}

			_UpdateNewName();
		}

		private void _ButtonAddChar_Click(object sender, EventArgs e)
		{
			_CheckedListBoxNameOfCharacters.Items.Add(_TextBoxCharName.Text);
		}

		private void _ButtonRemoveChar_Click(object sender, EventArgs e)
		{
			if (_CheckedListBoxNameOfCharacters.SelectedIndex >= 0)
			{
				_CheckedListBoxNameOfCharacters.Items.RemoveAt(_CheckedListBoxNameOfCharacters.SelectedIndex);
			}
		}

		private void _CheckedListBoxNameOfCharacters_MouseUp(object sender, MouseEventArgs e)
		{
			_UpdateNewName();
		}

		private void _CheckedListBoxNameOfCharacters_KeyUp(object sender, KeyEventArgs e)
		{
			_UpdateNewName();
		}

		private void _CheckedListBoxNameOfCharacters_SelectedIndexChanged(object sender, EventArgs e)
		{
			_UpdateNewName();
		}

		private void _ButtonApplyNewName_Click(object sender, EventArgs e)
		{
			ImageFile file = _GetSelectedFile();
			if (file == null)
			{
				return;
			}

			file.Rename(_TextBoxNewFileName.Text);
			_ListBoxFiles.Items.Remove(file);			
		}

		private void _ButtonClearFiles_Click(object sender, EventArgs e)
		{
			_ListBoxFiles.Items.Clear();
		}

		private void _CheckBoxAddPhoneName_CheckedChanged(object sender, EventArgs e)
		{
			_UpdateNewName();
		}

		private void _ToolStripMenuItemCopy_Click(object sender, EventArgs e)
		{
			try
			{
				string result = string.Empty;
				for (int i = 0; i < _CheckedListBoxNameOfCharacters.Items.Count; i++)
				{
					if (!string.IsNullOrEmpty(result))
					{
						result += "  ";
					}

					result += _CheckedListBoxNameOfCharacters.Items[i];
				}

				if(!string.IsNullOrEmpty(result))
				{
					Clipboard.SetText(result);
				}
			}
			catch (Exception ex)
			{
				MessageBox.Show(ex.ToString(), ex.Message);
			}			
		}

		private void _ExitToolStripMenuItem_Click(object sender, EventArgs e)
		{
			Close();
		}

		private void _PageComposerToolStripMenuItem_Click(object sender, EventArgs e)
		{
			string animeName = _TextBoxNameOfAnime.Text;
			if (string.IsNullOrWhiteSpace(animeName))
			{
				MessageBox.Show("Не указано название аниме", Text, MessageBoxButtons.OK, MessageBoxIcon.Information);
				return;
			}

			PageComposeForm composeForm = new PageComposeForm();
			composeForm.AnimeName = animeName;

			composeForm.ShowDialog();
		}
	}
}
