namespace SalkoDev.KawaiiTwitter
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
			System.ComponentModel.ComponentResourceManager resources = new System.ComponentModel.ComponentResourceManager(typeof(Form1));
			this.menuStrip1 = new System.Windows.Forms.MenuStrip();
			this.fileToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this._ConnectToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.updateFromSitemapToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.exitToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this._ListBoxLog = new System.Windows.Forms.ListBox();
			this._GroupBoxMainTweeting = new System.Windows.Forms.GroupBox();
			this._ButtonStopTweeting = new System.Windows.Forms.Button();
			this._ButtonStartTweeting = new System.Windows.Forms.Button();
			this._LabelNextPostTime = new System.Windows.Forms.Label();
			this._LabelLastPost = new System.Windows.Forms.Label();
			this._BackgroundWorkerTweeting = new System.ComponentModel.BackgroundWorker();
			this.loadNewImagesFromDiskToolStripMenuItem = new System.Windows.Forms.ToolStripMenuItem();
			this.menuStrip1.SuspendLayout();
			this._GroupBoxMainTweeting.SuspendLayout();
			this.SuspendLayout();
			// 
			// menuStrip1
			// 
			this.menuStrip1.Items.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this.fileToolStripMenuItem});
			this.menuStrip1.Location = new System.Drawing.Point(0, 0);
			this.menuStrip1.Name = "menuStrip1";
			this.menuStrip1.Size = new System.Drawing.Size(573, 24);
			this.menuStrip1.TabIndex = 0;
			this.menuStrip1.Text = "menuStrip1";
			// 
			// fileToolStripMenuItem
			// 
			this.fileToolStripMenuItem.DropDownItems.AddRange(new System.Windows.Forms.ToolStripItem[] {
            this._ConnectToolStripMenuItem,
            this.updateFromSitemapToolStripMenuItem,
            this.loadNewImagesFromDiskToolStripMenuItem,
            this.exitToolStripMenuItem});
			this.fileToolStripMenuItem.Name = "fileToolStripMenuItem";
			this.fileToolStripMenuItem.Size = new System.Drawing.Size(37, 20);
			this.fileToolStripMenuItem.Text = "File";
			// 
			// _ConnectToolStripMenuItem
			// 
			this._ConnectToolStripMenuItem.Name = "_ConnectToolStripMenuItem";
			this._ConnectToolStripMenuItem.Size = new System.Drawing.Size(228, 22);
			this._ConnectToolStripMenuItem.Text = "Connect to Twitter...";
			this._ConnectToolStripMenuItem.Click += new System.EventHandler(this._ConnectToolStripMenuItem_Click);
			// 
			// updateFromSitemapToolStripMenuItem
			// 
			this.updateFromSitemapToolStripMenuItem.Name = "updateFromSitemapToolStripMenuItem";
			this.updateFromSitemapToolStripMenuItem.Size = new System.Drawing.Size(228, 22);
			this.updateFromSitemapToolStripMenuItem.Text = "Update from sitemap...";
			this.updateFromSitemapToolStripMenuItem.Click += new System.EventHandler(this.updateFromSitemapToolStripMenuItem_Click);
			// 
			// exitToolStripMenuItem
			// 
			this.exitToolStripMenuItem.Name = "exitToolStripMenuItem";
			this.exitToolStripMenuItem.Size = new System.Drawing.Size(228, 22);
			this.exitToolStripMenuItem.Text = "Exit";
			this.exitToolStripMenuItem.Click += new System.EventHandler(this.exitToolStripMenuItem_Click);
			// 
			// _ListBoxLog
			// 
			this._ListBoxLog.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._ListBoxLog.FormattingEnabled = true;
			this._ListBoxLog.Location = new System.Drawing.Point(12, 27);
			this._ListBoxLog.Name = "_ListBoxLog";
			this._ListBoxLog.Size = new System.Drawing.Size(549, 108);
			this._ListBoxLog.TabIndex = 1;
			// 
			// _GroupBoxMainTweeting
			// 
			this._GroupBoxMainTweeting.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._GroupBoxMainTweeting.Controls.Add(this._ButtonStopTweeting);
			this._GroupBoxMainTweeting.Controls.Add(this._ButtonStartTweeting);
			this._GroupBoxMainTweeting.Controls.Add(this._LabelNextPostTime);
			this._GroupBoxMainTweeting.Controls.Add(this._LabelLastPost);
			this._GroupBoxMainTweeting.Location = new System.Drawing.Point(12, 141);
			this._GroupBoxMainTweeting.Name = "_GroupBoxMainTweeting";
			this._GroupBoxMainTweeting.Size = new System.Drawing.Size(549, 114);
			this._GroupBoxMainTweeting.TabIndex = 2;
			this._GroupBoxMainTweeting.TabStop = false;
			this._GroupBoxMainTweeting.Text = "Автоматическое размещение твитов";
			// 
			// _ButtonStopTweeting
			// 
			this._ButtonStopTweeting.Location = new System.Drawing.Point(90, 85);
			this._ButtonStopTweeting.Name = "_ButtonStopTweeting";
			this._ButtonStopTweeting.Size = new System.Drawing.Size(75, 23);
			this._ButtonStopTweeting.TabIndex = 3;
			this._ButtonStopTweeting.Text = "Стоп";
			this._ButtonStopTweeting.UseVisualStyleBackColor = true;
			this._ButtonStopTweeting.Click += new System.EventHandler(this._ButtonStopTweeting_Click);
			// 
			// _ButtonStartTweeting
			// 
			this._ButtonStartTweeting.Location = new System.Drawing.Point(9, 85);
			this._ButtonStartTweeting.Name = "_ButtonStartTweeting";
			this._ButtonStartTweeting.Size = new System.Drawing.Size(75, 23);
			this._ButtonStartTweeting.TabIndex = 2;
			this._ButtonStartTweeting.Text = "Старт";
			this._ButtonStartTweeting.UseVisualStyleBackColor = true;
			this._ButtonStartTweeting.Click += new System.EventHandler(this._ButtonStartTweeting_Click);
			// 
			// _LabelNextPostTime
			// 
			this._LabelNextPostTime.AutoSize = true;
			this._LabelNextPostTime.Location = new System.Drawing.Point(6, 61);
			this._LabelNextPostTime.Name = "_LabelNextPostTime";
			this._LabelNextPostTime.Size = new System.Drawing.Size(95, 13);
			this._LabelNextPostTime.TabIndex = 1;
			this._LabelNextPostTime.Text = "Следующий пост:";
			// 
			// _LabelLastPost
			// 
			this._LabelLastPost.AutoSize = true;
			this._LabelLastPost.Location = new System.Drawing.Point(6, 28);
			this._LabelLastPost.Name = "_LabelLastPost";
			this._LabelLastPost.Size = new System.Drawing.Size(92, 13);
			this._LabelLastPost.TabIndex = 0;
			this._LabelLastPost.Text = "Последний пост:";
			// 
			// _BackgroundWorkerTweeting
			// 
			this._BackgroundWorkerTweeting.WorkerReportsProgress = true;
			this._BackgroundWorkerTweeting.WorkerSupportsCancellation = true;
			this._BackgroundWorkerTweeting.DoWork += new System.ComponentModel.DoWorkEventHandler(this._BackgroundWorkerTweeting_DoWork);
			this._BackgroundWorkerTweeting.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this._BackgroundWorkerTweeting_RunWorkerCompleted);
			// 
			// loadNewImagesFromDiskToolStripMenuItem
			// 
			this.loadNewImagesFromDiskToolStripMenuItem.Name = "loadNewImagesFromDiskToolStripMenuItem";
			this.loadNewImagesFromDiskToolStripMenuItem.Size = new System.Drawing.Size(228, 22);
			this.loadNewImagesFromDiskToolStripMenuItem.Text = "Load new images from disk...";
			this.loadNewImagesFromDiskToolStripMenuItem.Click += new System.EventHandler(this.loadNewImagesFromDiskToolStripMenuItem_Click);
			// 
			// Form1
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(573, 298);
			this.Controls.Add(this._GroupBoxMainTweeting);
			this.Controls.Add(this._ListBoxLog);
			this.Controls.Add(this.menuStrip1);
			this.Icon = ((System.Drawing.Icon)(resources.GetObject("$this.Icon")));
			this.MainMenuStrip = this.menuStrip1;
			this.Name = "Form1";
			this.Text = "Kawaii Twitter";
			this.Load += new System.EventHandler(this.Form1_Load);
			this.menuStrip1.ResumeLayout(false);
			this.menuStrip1.PerformLayout();
			this._GroupBoxMainTweeting.ResumeLayout(false);
			this._GroupBoxMainTweeting.PerformLayout();
			this.ResumeLayout(false);
			this.PerformLayout();

		}

		#endregion

		private System.Windows.Forms.MenuStrip menuStrip1;
		private System.Windows.Forms.ToolStripMenuItem fileToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem exitToolStripMenuItem;
		private System.Windows.Forms.ListBox _ListBoxLog;
		private System.Windows.Forms.ToolStripMenuItem _ConnectToolStripMenuItem;
		private System.Windows.Forms.ToolStripMenuItem updateFromSitemapToolStripMenuItem;
		private System.Windows.Forms.GroupBox _GroupBoxMainTweeting;
		private System.Windows.Forms.Button _ButtonStopTweeting;
		private System.Windows.Forms.Button _ButtonStartTweeting;
		private System.Windows.Forms.Label _LabelNextPostTime;
		private System.Windows.Forms.Label _LabelLastPost;
		private System.ComponentModel.BackgroundWorker _BackgroundWorkerTweeting;
		private System.Windows.Forms.ToolStripMenuItem loadNewImagesFromDiskToolStripMenuItem;
	}
}

