namespace WallpaperImages
{
	partial class PageComposeForm
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
			this._CheckedListBoxResolutions = new System.Windows.Forms.CheckedListBox();
			this._ButtonClose = new System.Windows.Forms.Button();
			this._OKButton = new System.Windows.Forms.Button();
			this._TextBoxPage = new System.Windows.Forms.TextBox();
			this._LabelWiki = new System.Windows.Forms.Label();
			this._TextBoxWiki = new System.Windows.Forms.TextBox();
			this._LabelGenre = new System.Windows.Forms.Label();
			this._TextBoxGenre = new System.Windows.Forms.TextBox();
			this._CheckBoxTable = new System.Windows.Forms.CheckBox();
			this._CheckBoxReview = new System.Windows.Forms.CheckBox();
			this.SuspendLayout();
			// 
			// _CheckedListBoxResolutions
			// 
			this._CheckedListBoxResolutions.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left)));
			this._CheckedListBoxResolutions.FormattingEnabled = true;
			this._CheckedListBoxResolutions.Location = new System.Drawing.Point(12, 12);
			this._CheckedListBoxResolutions.Name = "_CheckedListBoxResolutions";
			this._CheckedListBoxResolutions.Size = new System.Drawing.Size(149, 289);
			this._CheckedListBoxResolutions.TabIndex = 4;
			this._CheckedListBoxResolutions.ItemCheck += new System.Windows.Forms.ItemCheckEventHandler(this._CheckedListBoxResolutions_ItemCheck);
			this._CheckedListBoxResolutions.KeyUp += new System.Windows.Forms.KeyEventHandler(this._CheckedListBoxResolutions_KeyUp);
			this._CheckedListBoxResolutions.MouseUp += new System.Windows.Forms.MouseEventHandler(this._CheckedListBoxResolutions_MouseUp);
			// 
			// _ButtonClose
			// 
			this._ButtonClose.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonClose.DialogResult = System.Windows.Forms.DialogResult.Cancel;
			this._ButtonClose.Location = new System.Drawing.Point(549, 401);
			this._ButtonClose.Name = "_ButtonClose";
			this._ButtonClose.Size = new System.Drawing.Size(75, 23);
			this._ButtonClose.TabIndex = 5;
			this._ButtonClose.Text = "Close";
			this._ButtonClose.UseVisualStyleBackColor = true;
			// 
			// _OKButton
			// 
			this._OKButton.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._OKButton.DialogResult = System.Windows.Forms.DialogResult.OK;
			this._OKButton.Location = new System.Drawing.Point(468, 401);
			this._OKButton.Name = "_OKButton";
			this._OKButton.Size = new System.Drawing.Size(75, 23);
			this._OKButton.TabIndex = 6;
			this._OKButton.Text = "OK";
			this._OKButton.UseVisualStyleBackColor = true;
			// 
			// _TextBoxPage
			// 
			this._TextBoxPage.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxPage.Location = new System.Drawing.Point(167, 12);
			this._TextBoxPage.Multiline = true;
			this._TextBoxPage.Name = "_TextBoxPage";
			this._TextBoxPage.Size = new System.Drawing.Size(457, 305);
			this._TextBoxPage.TabIndex = 7;
			// 
			// _LabelWiki
			// 
			this._LabelWiki.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._LabelWiki.AutoSize = true;
			this._LabelWiki.Location = new System.Drawing.Point(12, 327);
			this._LabelWiki.Name = "_LabelWiki";
			this._LabelWiki.Size = new System.Drawing.Size(76, 13);
			this._LabelWiki.TabIndex = 8;
			this._LabelWiki.Text = "Wikipedia link:";
			// 
			// _TextBoxWiki
			// 
			this._TextBoxWiki.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxWiki.Location = new System.Drawing.Point(94, 324);
			this._TextBoxWiki.Name = "_TextBoxWiki";
			this._TextBoxWiki.Size = new System.Drawing.Size(530, 20);
			this._TextBoxWiki.TabIndex = 9;
			this._TextBoxWiki.TextChanged += new System.EventHandler(this._TextBoxWiki_TextChanged);
			// 
			// _LabelGenre
			// 
			this._LabelGenre.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._LabelGenre.AutoSize = true;
			this._LabelGenre.Location = new System.Drawing.Point(12, 350);
			this._LabelGenre.Name = "_LabelGenre";
			this._LabelGenre.Size = new System.Drawing.Size(39, 13);
			this._LabelGenre.TabIndex = 10;
			this._LabelGenre.Text = "Genre:";
			// 
			// _TextBoxGenre
			// 
			this._TextBoxGenre.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxGenre.Location = new System.Drawing.Point(94, 347);
			this._TextBoxGenre.Name = "_TextBoxGenre";
			this._TextBoxGenre.Size = new System.Drawing.Size(530, 20);
			this._TextBoxGenre.TabIndex = 11;
			this._TextBoxGenre.TextChanged += new System.EventHandler(this._TextBoxGenre_TextChanged);
			// 
			// _CheckBoxTable
			// 
			this._CheckBoxTable.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._CheckBoxTable.AutoSize = true;
			this._CheckBoxTable.Checked = true;
			this._CheckBoxTable.CheckState = System.Windows.Forms.CheckState.Checked;
			this._CheckBoxTable.Location = new System.Drawing.Point(94, 373);
			this._CheckBoxTable.Name = "_CheckBoxTable";
			this._CheckBoxTable.Size = new System.Drawing.Size(199, 17);
			this._CheckBoxTable.TabIndex = 12;
			this._CheckBoxTable.Text = "Шаблон страницы в виде таблицы";
			this._CheckBoxTable.UseVisualStyleBackColor = true;
			this._CheckBoxTable.CheckedChanged += new System.EventHandler(this._CheckBoxTable_CheckedChanged);
			// 
			// _CheckBoxReview
			// 
			this._CheckBoxReview.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Left)));
			this._CheckBoxReview.AutoSize = true;
			this._CheckBoxReview.Location = new System.Drawing.Point(359, 373);
			this._CheckBoxReview.Name = "_CheckBoxReview";
			this._CheckBoxReview.Size = new System.Drawing.Size(89, 17);
			this._CheckBoxReview.TabIndex = 13;
			this._CheckBoxReview.Text = "Review-блок";
			this._CheckBoxReview.UseVisualStyleBackColor = true;
			this._CheckBoxReview.CheckedChanged += new System.EventHandler(this._CheckBoxReview_CheckedChanged);
			// 
			// PageComposeForm
			// 
			this.AcceptButton = this._OKButton;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.CancelButton = this._ButtonClose;
			this.ClientSize = new System.Drawing.Size(636, 436);
			this.Controls.Add(this._CheckBoxReview);
			this.Controls.Add(this._CheckBoxTable);
			this.Controls.Add(this._TextBoxGenre);
			this.Controls.Add(this._LabelGenre);
			this.Controls.Add(this._TextBoxWiki);
			this.Controls.Add(this._LabelWiki);
			this.Controls.Add(this._TextBoxPage);
			this.Controls.Add(this._OKButton);
			this.Controls.Add(this._ButtonClose);
			this.Controls.Add(this._CheckedListBoxResolutions);
			this.MaximizeBox = false;
			this.MinimizeBox = false;
			this.Name = "PageComposeForm";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
			this.Text = "Компоновка страницы";
			this.Load += new System.EventHandler(this.PageComposeForm_Load);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.CheckedListBox _CheckedListBoxResolutions;
		private System.Windows.Forms.Button _ButtonClose;
		private System.Windows.Forms.Button _OKButton;
		private System.Windows.Forms.TextBox _TextBoxPage;
		private System.Windows.Forms.Label _LabelWiki;
		private System.Windows.Forms.TextBox _TextBoxWiki;
		private System.Windows.Forms.Label _LabelGenre;
		private System.Windows.Forms.TextBox _TextBoxGenre;
		private System.Windows.Forms.CheckBox _CheckBoxTable;
		private System.Windows.Forms.CheckBox _CheckBoxReview;
	}
}