namespace SalkoDev.KawaiiTwitter
{
	partial class UpdateSitemapForm
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
			this._ButtonCancel = new System.Windows.Forms.Button();
			this._ButtonOK = new System.Windows.Forms.Button();
			this._LabelMain = new System.Windows.Forms.Label();
			this._TextBoxURL = new System.Windows.Forms.TextBox();
			this._LabelProgress = new System.Windows.Forms.Label();
			this._BackgroundWorker = new System.ComponentModel.BackgroundWorker();
			this.SuspendLayout();
			// 
			// _ButtonCancel
			// 
			this._ButtonCancel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonCancel.DialogResult = System.Windows.Forms.DialogResult.Cancel;
			this._ButtonCancel.Location = new System.Drawing.Point(305, 135);
			this._ButtonCancel.Name = "_ButtonCancel";
			this._ButtonCancel.Size = new System.Drawing.Size(94, 23);
			this._ButtonCancel.TabIndex = 0;
			this._ButtonCancel.Text = "Скасувати";
			this._ButtonCancel.UseVisualStyleBackColor = true;
			// 
			// _ButtonOK
			// 
			this._ButtonOK.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonOK.Location = new System.Drawing.Point(203, 135);
			this._ButtonOK.Name = "_ButtonOK";
			this._ButtonOK.Size = new System.Drawing.Size(96, 23);
			this._ButtonOK.TabIndex = 1;
			this._ButtonOK.Text = "OK";
			this._ButtonOK.UseVisualStyleBackColor = true;
			this._ButtonOK.Click += new System.EventHandler(this._ButtonOK_Click);
			// 
			// _LabelMain
			// 
			this._LabelMain.AutoSize = true;
			this._LabelMain.Location = new System.Drawing.Point(12, 9);
			this._LabelMain.Name = "_LabelMain";
			this._LabelMain.Size = new System.Drawing.Size(141, 13);
			this._LabelMain.TabIndex = 2;
			this._LabelMain.Text = "URL карти сайту сторінок:";
			// 
			// _TextBoxURL
			// 
			this._TextBoxURL.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxURL.Location = new System.Drawing.Point(12, 25);
			this._TextBoxURL.Name = "_TextBoxURL";
			this._TextBoxURL.Size = new System.Drawing.Size(387, 20);
			this._TextBoxURL.TabIndex = 3;
			// 
			// _LabelProgress
			// 
			this._LabelProgress.AutoSize = true;
			this._LabelProgress.Location = new System.Drawing.Point(9, 62);
			this._LabelProgress.Name = "_LabelProgress";
			this._LabelProgress.Size = new System.Drawing.Size(93, 13);
			this._LabelProgress.TabIndex = 4;
			this._LabelProgress.Text = "(Завантажено ...)";
			// 
			// _BackgroundWorker
			// 
			this._BackgroundWorker.WorkerReportsProgress = true;
			this._BackgroundWorker.WorkerSupportsCancellation = true;
			this._BackgroundWorker.DoWork += new System.ComponentModel.DoWorkEventHandler(this._BackgroundWorker_DoWork);
			this._BackgroundWorker.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this._BackgroundWorker_RunWorkerCompleted);
			// 
			// UpdateSitemapForm
			// 
			this.AcceptButton = this._ButtonOK;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.CancelButton = this._ButtonCancel;
			this.ClientSize = new System.Drawing.Size(411, 170);
			this.Controls.Add(this._LabelProgress);
			this.Controls.Add(this._TextBoxURL);
			this.Controls.Add(this._LabelMain);
			this.Controls.Add(this._ButtonOK);
			this.Controls.Add(this._ButtonCancel);
			this.MaximizeBox = false;
			this.Name = "UpdateSitemapForm";
			this.Text = "Оновлення сторінок з карти сайту";
			this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.UpdateSitemapForm_FormClosing);
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.Button _ButtonCancel;
		private System.Windows.Forms.Button _ButtonOK;
		private System.Windows.Forms.Label _LabelMain;
		private System.Windows.Forms.TextBox _TextBoxURL;
		private System.Windows.Forms.Label _LabelProgress;
		private System.ComponentModel.BackgroundWorker _BackgroundWorker;
	}
}