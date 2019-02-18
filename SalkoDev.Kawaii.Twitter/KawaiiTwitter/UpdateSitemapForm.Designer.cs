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
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(UpdateSitemapForm));
			this._ButtonCancel = new System.Windows.Forms.Button();
			this._ButtonOK = new System.Windows.Forms.Button();
			this._LabelMain = new System.Windows.Forms.Label();
			this._TextBoxURL = new System.Windows.Forms.TextBox();
			this._LabelProgress = new System.Windows.Forms.Label();
			this._BackgroundWorker = new System.ComponentModel.BackgroundWorker();
			this._CheckBoxLimit = new System.Windows.Forms.CheckBox();
			this._TextBoxLimitCount = new System.Windows.Forms.TextBox();
			this.SuspendLayout();
			// 
			// _ButtonCancel
			// 
			this._ButtonCancel.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonCancel.DialogResult = System.Windows.Forms.DialogResult.Cancel;
			this._ButtonCancel.Location = new System.Drawing.Point(428, 125);
			this._ButtonCancel.Name = "_ButtonCancel";
			this._ButtonCancel.Size = new System.Drawing.Size(75, 23);
			this._ButtonCancel.TabIndex = 0;
			this._ButtonCancel.Text = "Скасувати";
			this._ButtonCancel.UseVisualStyleBackColor = true;
			// 
			// _ButtonOK
			// 
			this._ButtonOK.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonOK.Location = new System.Drawing.Point(347, 125);
			this._ButtonOK.Name = "_ButtonOK";
			this._ButtonOK.Size = new System.Drawing.Size(75, 23);
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
			this._TextBoxURL.Size = new System.Drawing.Size(491, 20);
			this._TextBoxURL.TabIndex = 3;
			// 
			// _LabelProgress
			// 
			this._LabelProgress.AutoSize = true;
			this._LabelProgress.Location = new System.Drawing.Point(12, 107);
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
			// _CheckBoxLimit
			// 
			this._CheckBoxLimit.AutoSize = true;
			this._CheckBoxLimit.Checked = true;
			this._CheckBoxLimit.CheckState = System.Windows.Forms.CheckState.Checked;
			this._CheckBoxLimit.Location = new System.Drawing.Point(15, 60);
			this._CheckBoxLimit.Name = "_CheckBoxLimit";
			this._CheckBoxLimit.Size = new System.Drawing.Size(274, 17);
			this._CheckBoxLimit.TabIndex = 5;
			this._CheckBoxLimit.Text = "Обмежити останніми сторінками (більш новими):";
			this._CheckBoxLimit.UseVisualStyleBackColor = true;
			// 
			// _TextBoxLimitCount
			// 
			this._TextBoxLimitCount.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxLimitCount.Location = new System.Drawing.Point(428, 57);
			this._TextBoxLimitCount.Name = "_TextBoxLimitCount";
			this._TextBoxLimitCount.Size = new System.Drawing.Size(75, 20);
			this._TextBoxLimitCount.TabIndex = 6;
			this._TextBoxLimitCount.Text = "5";
			// 
			// UpdateSitemapForm
			// 
			this.AcceptButton = this._ButtonOK;
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.CancelButton = this._ButtonCancel;
			this.ClientSize = new System.Drawing.Size(515, 160);
			this.Controls.Add(this._TextBoxLimitCount);
			this.Controls.Add(this._CheckBoxLimit);
			this.Controls.Add(this._LabelProgress);
			this.Controls.Add(this._TextBoxURL);
			this.Controls.Add(this._LabelMain);
			this.Controls.Add(this._ButtonOK);
			this.Controls.Add(this._ButtonCancel);
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.MaximizeBox = false;
			this.Name = "UpdateSitemapForm";
			this.StartPosition = System.Windows.Forms.FormStartPosition.CenterParent;
			this.Text = "Оновлення сторінок з карти сайту";
			this.FormClosing += new System.Windows.Forms.FormClosingEventHandler(this.UpdateSitemapForm_FormClosing);
			this.Load += new System.EventHandler(this.UpdateSitemapForm_Load);
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
		private System.Windows.Forms.CheckBox _CheckBoxLimit;
		private System.Windows.Forms.TextBox _TextBoxLimitCount;
	}
}