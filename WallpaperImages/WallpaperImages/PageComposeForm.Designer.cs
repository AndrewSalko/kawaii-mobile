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
			this.SuspendLayout();
			// 
			// _CheckedListBoxResolutions
			// 
			this._CheckedListBoxResolutions.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left)));
			this._CheckedListBoxResolutions.FormattingEnabled = true;
			this._CheckedListBoxResolutions.Location = new System.Drawing.Point(12, 12);
			this._CheckedListBoxResolutions.Name = "_CheckedListBoxResolutions";
			this._CheckedListBoxResolutions.Size = new System.Drawing.Size(149, 319);
			this._CheckedListBoxResolutions.TabIndex = 4;
			this._CheckedListBoxResolutions.ItemCheck += new System.Windows.Forms.ItemCheckEventHandler(this._CheckedListBoxResolutions_ItemCheck);
			this._CheckedListBoxResolutions.KeyUp += new System.Windows.Forms.KeyEventHandler(this._CheckedListBoxResolutions_KeyUp);
			this._CheckedListBoxResolutions.MouseUp += new System.Windows.Forms.MouseEventHandler(this._CheckedListBoxResolutions_MouseUp);
			// 
			// _ButtonClose
			// 
			this._ButtonClose.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonClose.DialogResult = System.Windows.Forms.DialogResult.Cancel;
			this._ButtonClose.Location = new System.Drawing.Point(517, 348);
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
			this._OKButton.Location = new System.Drawing.Point(436, 348);
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
			this._TextBoxPage.Size = new System.Drawing.Size(425, 316);
			this._TextBoxPage.TabIndex = 7;
			// 
			// PageComposeForm
			// 
			this.AcceptButton = this._OKButton;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.CancelButton = this._ButtonClose;
			this.ClientSize = new System.Drawing.Size(604, 383);
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


	}
}