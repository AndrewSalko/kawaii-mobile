namespace SalkoDev.KawaiiTwitter
{
	partial class AuthForm
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
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(AuthForm));
			this._ButtonClose = new System.Windows.Forms.Button();
			this._WebBrowser = new System.Windows.Forms.WebBrowser();
			this.SuspendLayout();
			// 
			// _ButtonClose
			// 
			this._ButtonClose.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonClose.DialogResult = System.Windows.Forms.DialogResult.OK;
			this._ButtonClose.Location = new System.Drawing.Point(468, 345);
			this._ButtonClose.Name = "_ButtonClose";
			this._ButtonClose.Size = new System.Drawing.Size(81, 23);
			this._ButtonClose.TabIndex = 0;
			this._ButtonClose.Text = "Close";
			this._ButtonClose.UseVisualStyleBackColor = true;
			this._ButtonClose.Click += new System.EventHandler(this._ButtonClose_Click);
			// 
			// _WebBrowser
			// 
			this._WebBrowser.Anchor = ((System.Windows.Forms.AnchorStyles)((((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Bottom) 
            | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._WebBrowser.Location = new System.Drawing.Point(12, 12);
			this._WebBrowser.MinimumSize = new System.Drawing.Size(20, 20);
			this._WebBrowser.Name = "_WebBrowser";
			this._WebBrowser.Size = new System.Drawing.Size(537, 327);
			this._WebBrowser.TabIndex = 1;
			// 
			// AuthForm
			// 
			this.AcceptButton = this._ButtonClose;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(561, 380);
			this.Controls.Add(this._WebBrowser);
			this.Controls.Add(this._ButtonClose);
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.MaximizeBox = false;
			this.MinimizeBox = false;
			this.Name = "AuthForm";
			this.Text = "Twitter authorization";
			this.Load += new System.EventHandler(this.AuthForm_Load);
			this.ResumeLayout(false);

		}

		#endregion

		private System.Windows.Forms.Button _ButtonClose;
		private System.Windows.Forms.WebBrowser _WebBrowser;
	}
}