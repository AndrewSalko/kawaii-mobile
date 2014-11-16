namespace WallpaperImages
{
	partial class Form1
	{
		/// <summary>
		/// Required designer variable.
		/// </summary>
		private System.ComponentModel.IContainer components = null;

		/// <summary>
		/// Clean up any resources being used.
		/// </summary>
		/// <param name="disposing">true if managed resources should be disposed; otherwise, false.</param>
		protected override void Dispose(bool disposing)
		{
			if (disposing && (components != null))
			{
				components.Dispose();
			}
			base.Dispose(disposing);
		}

		#region Windows Form Designer generated code

		/// <summary>
		/// Required method for Designer support - do not modify
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{
			this.components = new System.ComponentModel.Container();
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Form1));
			this._LabelNameOfAnime = new System.Windows.Forms.Label();
			this._TextBoxNameOfAnime = new System.Windows.Forms.TextBox();
			this._GroupBoxCharacters = new System.Windows.Forms.GroupBox();
			this._TextBoxCharName = new System.Windows.Forms.TextBox();
			this._ButtonRemoveChar = new System.Windows.Forms.Button();
			this._ButtonAddChar = new System.Windows.Forms.Button();
			this._CheckedListBoxNameOfCharacters = new System.Windows.Forms.CheckedListBox();
			this._ContextMenuChars = new System.Windows.Forms.ContextMenuStrip(this.components);
			this._ToolStripMenuItemCopy = new System.Windows.Forms.ToolStripMenuItem();
			this._GroupBoxFiles = new System.Windows.Forms.GroupBox();
			this._ButtonClearFiles = new System.Windows.Forms.Button();
			this._ButtonOpenFiles = new System.Windows.Forms.Button();
			this._ListBoxFiles = new System.Windows.Forms.ListBox();
			this.openFileDialog1 = new System.Windows.Forms.OpenFileDialog();
			this._PictureBox = new System.Windows.Forms.PictureBox();
			this._LabelNewName = new System.Windows.Forms.Label();
			this._TextBoxNewFileName = new System.Windows.Forms.TextBox();
			this._ButtonApplyNewName = new System.Windows.Forms.Button();
			this._CheckBoxAddPhoneName = new System.Windows.Forms.CheckBox();
			this._MainMenuStrip = new System.Windows.Forms.MenuStrip();
			this._FileToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this._PageComposerToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this._ExitToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this._GroupBoxCharacters.SuspendLayout();
			this._ContextMenuChars.SuspendLayout();
			this._GroupBoxFiles.SuspendLayout();
			((System.ComponentModel.ISupportInitialize)(this._PictureBox)).BeginInit();
			this._MainMenuStrip.SuspendLayout();
			this.SuspendLayout();
			// 
			// _LabelNameOfAnime
			// 
			this._LabelNameOfAnime.AutoSize = true;
			this._LabelNameOfAnime.Location = new System.Drawing.Point(12, 9);
			this._LabelNameOfAnime.Name = "_LabelNameOfAnime";
			this._LabelNameOfAnime.Size = new System.Drawing.Size(95, 13);
			this._LabelNameOfAnime.TabIndex = 0;
			this._LabelNameOfAnime.Text = "Название аниме:";
			// 
			// _TextBoxNameOfAnime
			// 
			this._TextBoxNameOfAnime.Location = new System.Drawing.Point(15, 25);
			this._TextBoxNameOfAnime.Name = "_TextBoxNameOfAnime";
			this._TextBoxNameOfAnime.Size = new System.Drawing.Size(319, 20);
			this._TextBoxNameOfAnime.TabIndex = 1;
			this._TextBoxNameOfAnime.TextChanged += new System.EventHandler(this._TextBoxNameOfAnime_TextChanged);
			// 
			// _GroupBoxCharacters
			// 
			this._GroupBoxCharacters.Controls.Add(this._TextBoxCharName);
			this._GroupBoxCharacters.Controls.Add(this._ButtonRemoveChar);
			this._GroupBoxCharacters.Controls.Add(this._ButtonAddChar);
			this._GroupBoxCharacters.Controls.Add(this._CheckedListBoxNameOfCharacters);
			this._GroupBoxCharacters.Location = new System.Drawing.Point(15, 51);
			this._GroupBoxCharacters.Name = "_GroupBoxCharacters";
			this._GroupBoxCharacters.Size = new System.Drawing.Size(319, 225);
			this._GroupBoxCharacters.TabIndex = 3;
			this._GroupBoxCharacters.TabStop = false;
			this._GroupBoxCharacters.Text = "Персонажи аниме";
			// 
			// _TextBoxCharName
			// 
			this._TextBoxCharName.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxCharName.Location = new System.Drawing.Point(3, 19);
			this._TextBoxCharName.Name = "_TextBoxCharName";
			this._TextBoxCharName.Size = new System.Drawing.Size(148, 20);
			this._TextBoxCharName.TabIndex = 6;
			// 
			// _ButtonRemoveChar
			// 
			this._ButtonRemoveChar.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonRemoveChar.Location = new System.Drawing.Point(238, 17);
			this._ButtonRemoveChar.Name = "_ButtonRemoveChar";
			this._ButtonRemoveChar.Size = new System.Drawing.Size(75, 23);
			this._ButtonRemoveChar.TabIndex = 5;
			this._ButtonRemoveChar.Text = "Удалить";
			this._ButtonRemoveChar.UseVisualStyleBackColor = true;
			this._ButtonRemoveChar.Click += new System.EventHandler(this._ButtonRemoveChar_Click);
			// 
			// _ButtonAddChar
			// 
			this._ButtonAddChar.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonAddChar.Location = new System.Drawing.Point(157, 17);
			this._ButtonAddChar.Name = "_ButtonAddChar";
			this._ButtonAddChar.Size = new System.Drawing.Size(75, 23);
			this._ButtonAddChar.TabIndex = 4;
			this._ButtonAddChar.Text = "Добавить";
			this._ButtonAddChar.UseVisualStyleBackColor = true;
			this._ButtonAddChar.Click += new System.EventHandler(this._ButtonAddChar_Click);
			// 
			// _CheckedListBoxNameOfCharacters
			// 
			this._CheckedListBoxNameOfCharacters.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._CheckedListBoxNameOfCharacters.ContextMenuStrip = this._ContextMenuChars;
			this._CheckedListBoxNameOfCharacters.FormattingEnabled = true;
			this._CheckedListBoxNameOfCharacters.Location = new System.Drawing.Point(6, 51);
			this._CheckedListBoxNameOfCharacters.Name = "_CheckedListBoxNameOfCharacters";
			this._CheckedListBoxNameOfCharacters.Size = new System.Drawing.Size(307, 169);
			this._CheckedListBoxNameOfCharacters.TabIndex = 3;
			this._CheckedListBoxNameOfCharacters.ItemCheck += new System.Windows.Forms.ItemCheckEventHandler(this._CheckedListBoxNameOfCharacters_ItemCheck);
			this._CheckedListBoxNameOfCharacters.SelectedIndexChanged += new System.EventHandler(this._CheckedListBoxNameOfCharacters_SelectedIndexChanged);
			this._CheckedListBoxNameOfCharacters.KeyUp += new System.Windows.Forms.KeyEventHandler(this._CheckedListBoxNameOfCharacters_KeyUp);
			this._CheckedListBoxNameOfCharacters.MouseUp += new System.Windows.Forms.MouseEventHandler(this._CheckedListBoxNameOfCharacters_MouseUp);
			// 
			// _ContextMenuChars
			// 
			this._ContextMenuChars.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this._ToolStripMenuItemCopy});
			this._ContextMenuChars.Name = "_ContextMenuChars";
			this._ContextMenuChars.Size = new System.Drawing.Size(187, 26);
			// 
			// _ToolStripMenuItemCopy
			// 
			this._ToolStripMenuItemCopy.Name = "_ToolStripMenuItemCopy";
			this._ToolStripMenuItemCopy.Size = new System.Drawing.Size(186, 22);
			this._ToolStripMenuItemCopy.Text = "Копировать в буфер";
			this._ToolStripMenuItemCopy.Click += new System.EventHandler(this._ToolStripMenuItemCopy_Click);
			// 
			// _GroupBoxFiles
			// 
			this._GroupBoxFiles.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left)));
			this._GroupBoxFiles.Controls.Add(this._ButtonClearFiles);
			this._GroupBoxFiles.Controls.Add(this._ButtonOpenFiles);
			this._GroupBoxFiles.Controls.Add(this._ListBoxFiles);
			this._GroupBoxFiles.Location = new System.Drawing.Point(15, 282);
			this._GroupBoxFiles.Name = "_GroupBoxFiles";
			this._GroupBoxFiles.Size = new System.Drawing.Size(319, 191);
			this._GroupBoxFiles.TabIndex = 5;
			this._GroupBoxFiles.TabStop = false;
			this._GroupBoxFiles.Text = "Файлы для обработки";
			// 
			// _ButtonClearFiles
			// 
			this._ButtonClearFiles.Location = new System.Drawing.Point(140, 17);
			this._ButtonClearFiles.Name = "_ButtonClearFiles";
			this._ButtonClearFiles.Size = new System.Drawing.Size(106, 23);
			this._ButtonClearFiles.TabIndex = 7;
			this._ButtonClearFiles.Text = "Очистить список";
			this._ButtonClearFiles.UseVisualStyleBackColor = true;
			this._ButtonClearFiles.Click += new System.EventHandler(this._ButtonClearFiles_Click);
			// 
			// _ButtonOpenFiles
			// 
			this._ButtonOpenFiles.Location = new System.Drawing.Point(6, 17);
			this._ButtonOpenFiles.Name = "_ButtonOpenFiles";
			this._ButtonOpenFiles.Size = new System.Drawing.Size(128, 23);
			this._ButtonOpenFiles.TabIndex = 6;
			this._ButtonOpenFiles.Text = "Выбрать файлы";
			this._ButtonOpenFiles.UseVisualStyleBackColor = true;
			this._ButtonOpenFiles.Click += new System.EventHandler(this._ButtonOpenFiles_Click);
			// 
			// _ListBoxFiles
			// 
			this._ListBoxFiles.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._ListBoxFiles.FormattingEnabled = true;
			this._ListBoxFiles.Location = new System.Drawing.Point(6, 42);
			this._ListBoxFiles.Name = "_ListBoxFiles";
			this._ListBoxFiles.Size = new System.Drawing.Size(307, 121);
			this._ListBoxFiles.Sorted = true;
			this._ListBoxFiles.TabIndex = 5;
			this._ListBoxFiles.SelectedIndexChanged += new System.EventHandler(this._ListBoxFiles_SelectedIndexChanged);
			// 
			// openFileDialog1
			// 
			this.openFileDialog1.DefaultExt = "JPG";
			this.openFileDialog1.Filter = "Jpg files (*.jpg)|*.jpg|Png files (*.png)|*.png";
			this.openFileDialog1.Multiselect = true;
			this.openFileDialog1.Title = "Файлы для обработки";
			// 
			// _PictureBox
			// 
			this._PictureBox.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._PictureBox.BorderStyle = System.Windows.Forms.BorderStyle.FixedSingle;
			this._PictureBox.Location = new System.Drawing.Point(340, 12);
			this._PictureBox.Name = "_PictureBox";
			this._PictureBox.Size = new System.Drawing.Size(358, 347);
			this._PictureBox.SizeMode = System.Windows.Forms.PictureBoxSizeMode.Zoom;
			this._PictureBox.TabIndex = 6;
			this._PictureBox.TabStop = false;
			// 
			// _LabelNewName
			// 
			this._LabelNewName.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._LabelNewName.AutoSize = true;
			this._LabelNewName.Location = new System.Drawing.Point(340, 368);
			this._LabelNewName.Name = "_LabelNewName";
			this._LabelNewName.Size = new System.Drawing.Size(100, 13);
			this._LabelNewName.TabIndex = 7;
			this._LabelNewName.Text = "Новое имя файла:";
			// 
			// _TextBoxNewFileName
			// 
			this._TextBoxNewFileName.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxNewFileName.Location = new System.Drawing.Point(343, 384);
			this._TextBoxNewFileName.Name = "_TextBoxNewFileName";
			this._TextBoxNewFileName.Size = new System.Drawing.Size(355, 20);
			this._TextBoxNewFileName.TabIndex = 8;
			// 
			// _ButtonApplyNewName
			// 
			this._ButtonApplyNewName.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._ButtonApplyNewName.Location = new System.Drawing.Point(343, 433);
			this._ButtonApplyNewName.Name = "_ButtonApplyNewName";
			this._ButtonApplyNewName.Size = new System.Drawing.Size(228, 23);
			this._ButtonApplyNewName.TabIndex = 9;
			this._ButtonApplyNewName.Text = "Установить новое имя файлу";
			this._ButtonApplyNewName.UseVisualStyleBackColor = true;
			this._ButtonApplyNewName.Click += new System.EventHandler(this._ButtonApplyNewName_Click);
			// 
			// _CheckBoxAddPhoneName
			// 
			this._CheckBoxAddPhoneName.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._CheckBoxAddPhoneName.AutoSize = true;
			this._CheckBoxAddPhoneName.Checked = true;
			this._CheckBoxAddPhoneName.CheckState = System.Windows.Forms.CheckState.Checked;
			this._CheckBoxAddPhoneName.Location = new System.Drawing.Point(343, 410);
			this._CheckBoxAddPhoneName.Name = "_CheckBoxAddPhoneName";
			this._CheckBoxAddPhoneName.Size = new System.Drawing.Size(253, 17);
			this._CheckBoxAddPhoneName.TabIndex = 10;
			this._CheckBoxAddPhoneName.Text = "Добавлять имя телефона и ключевые слова";
			this._CheckBoxAddPhoneName.UseVisualStyleBackColor = true;
			this._CheckBoxAddPhoneName.CheckedChanged += new System.EventHandler(this._CheckBoxAddPhoneName_CheckedChanged);
			// 
			// _MainMenuStrip
			// 
			this._MainMenuStrip.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this._FileToolStripMenuItem});
			this._MainMenuStrip.Location = new System.Drawing.Point(0, 0);
			this._MainMenuStrip.Name = "_MainMenuStrip";
			this._MainMenuStrip.Size = new System.Drawing.Size(710, 24);
			this._MainMenuStrip.TabIndex = 11;
			this._MainMenuStrip.Text = "menuStrip1";
			// 
			// _FileToolStripMenuItem
			// 
			this._FileToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this._PageComposerToolStripMenuItem,
            this._ExitToolStripMenuItem});
			this._FileToolStripMenuItem.Name = "_FileToolStripMenuItem";
			this._FileToolStripMenuItem.Size = new System.Drawing.Size(48, 20);
			this._FileToolStripMenuItem.Text = "Файл";
			// 
			// _PageComposerToolStripMenuItem
			// 
			this._PageComposerToolStripMenuItem.Name = "_PageComposerToolStripMenuItem";
			this._PageComposerToolStripMenuItem.Size = new System.Drawing.Size(224, 22);
			this._PageComposerToolStripMenuItem.Text = "Компоновка веб-страницы";
			this._PageComposerToolStripMenuItem.Click += new System.EventHandler(this._PageComposerToolStripMenuItem_Click);
			// 
			// _ExitToolStripMenuItem
			// 
			this._ExitToolStripMenuItem.Name = "_ExitToolStripMenuItem";
			this._ExitToolStripMenuItem.Size = new System.Drawing.Size(224, 22);
			this._ExitToolStripMenuItem.Text = "Выход";
			this._ExitToolStripMenuItem.Click += new System.EventHandler(this._ExitToolStripMenuItem_Click);
			// 
			// Form1
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(710, 487);
			this.Controls.Add(this._MainMenuStrip);
			this.Controls.Add(this._CheckBoxAddPhoneName);
			this.Controls.Add(this._ButtonApplyNewName);
			this.Controls.Add(this._TextBoxNewFileName);
			this.Controls.Add(this._LabelNewName);
			this.Controls.Add(this._PictureBox);
			this.Controls.Add(this._GroupBoxFiles);
			this.Controls.Add(this._GroupBoxCharacters);
			this.Controls.Add(this._TextBoxNameOfAnime);
			this.Controls.Add(this._LabelNameOfAnime);
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.MainMenuStrip = this._MainMenuStrip;
			this.Name = "Form1";
			this.Text = "Подготовка изображений-обоев для поста на сайт";
			this._GroupBoxCharacters.ResumeLayout(false);
			this._GroupBoxCharacters.PerformLayout();
			this._ContextMenuChars.ResumeLayout(false);
			this._GroupBoxFiles.ResumeLayout(false);
			((System.ComponentModel.ISupportInitialize)(this._PictureBox)).EndInit();
			this._MainMenuStrip.ResumeLayout(false);
			this._MainMenuStrip.PerformLayout();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Label _LabelNameOfAnime;
		private System.Windows.Forms.TextBox _TextBoxNameOfAnime;
		private System.Windows.Forms.GroupBox _GroupBoxCharacters;
		private System.Windows.Forms.CheckedListBox _CheckedListBoxNameOfCharacters;
		private System.Windows.Forms.Button _ButtonAddChar;
		private System.Windows.Forms.TextBox _TextBoxCharName;
		private System.Windows.Forms.Button _ButtonRemoveChar;
		private System.Windows.Forms.GroupBox _GroupBoxFiles;
		private System.Windows.Forms.Button _ButtonOpenFiles;
		private System.Windows.Forms.ListBox _ListBoxFiles;
		private System.Windows.Forms.OpenFileDialog openFileDialog1;
		private System.Windows.Forms.PictureBox _PictureBox;
		private System.Windows.Forms.Label _LabelNewName;
		private System.Windows.Forms.TextBox _TextBoxNewFileName;
		private System.Windows.Forms.Button _ButtonApplyNewName;
		private System.Windows.Forms.Button _ButtonClearFiles;
		private System.Windows.Forms.CheckBox _CheckBoxAddPhoneName;
		private System.Windows.Forms.ContextMenuStrip _ContextMenuChars;
		private System.Windows.Forms.ToolStripMenuItem _ToolStripMenuItemCopy;
		private System.Windows.Forms.MenuStrip _MainMenuStrip;
		private System.Windows.Forms.ToolStripMenuItem _FileToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem _PageComposerToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem _ExitToolStripMenuItem;
	}
}

