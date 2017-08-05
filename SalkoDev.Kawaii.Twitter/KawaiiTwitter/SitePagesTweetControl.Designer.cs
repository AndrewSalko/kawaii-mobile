namespace SalkoDev.KawaiiTwitter
{
	partial class SitePagesTweetControl
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

		#region Component Designer generated code

		/// <summary> 
		/// Required method for Designer support - do not modify 
		/// the contents of this method with the code editor.
		/// </summary>
		private void InitializeComponent()
		{
			this._GroupBoxSitemap = new System.Windows.Forms.GroupBox();
			this._ButtonStopLoadSitemap = new System.Windows.Forms.Button();
			this._LabelTotalURLs = new System.Windows.Forms.Label();
			this._ButtonLoadSitemap = new System.Windows.Forms.Button();
			this._TextBoxURLSitemap = new System.Windows.Forms.TextBox();
			this._LabelURL = new System.Windows.Forms.Label();
			this._BackgroundWorkerSitemapLoad = new System.ComponentModel.BackgroundWorker();
			this._GroupBoxMainTweeting = new System.Windows.Forms.GroupBox();
			this._ButtonStopTweeting = new System.Windows.Forms.Button();
			this._ButtonStartTweeting = new System.Windows.Forms.Button();
			this._LabelNextPostTime = new System.Windows.Forms.Label();
			this._LabelLastPost = new System.Windows.Forms.Label();
			this._BackgroundWorkerTweeting = new System.ComponentModel.BackgroundWorker();
			this._GroupBoxLoadImages = new System.Windows.Forms.GroupBox();
			this._ButtonLoadImages = new System.Windows.Forms.Button();
			this._BackgroundWorkerLoadImages = new System.ComponentModel.BackgroundWorker();
			this._GroupBoxSitemap.SuspendLayout();
			this._GroupBoxMainTweeting.SuspendLayout();
			this._GroupBoxLoadImages.SuspendLayout();
			this.SuspendLayout();
			// 
			// _GroupBoxSitemap
			// 
			this._GroupBoxSitemap.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._GroupBoxSitemap.Controls.Add(this._ButtonStopLoadSitemap);
			this._GroupBoxSitemap.Controls.Add(this._LabelTotalURLs);
			this._GroupBoxSitemap.Controls.Add(this._ButtonLoadSitemap);
			this._GroupBoxSitemap.Controls.Add(this._TextBoxURLSitemap);
			this._GroupBoxSitemap.Controls.Add(this._LabelURL);
			this._GroupBoxSitemap.Location = new System.Drawing.Point(3, 3);
			this._GroupBoxSitemap.Name = "_GroupBoxSitemap";
			this._GroupBoxSitemap.Size = new System.Drawing.Size(481, 76);
			this._GroupBoxSitemap.TabIndex = 0;
			this._GroupBoxSitemap.TabStop = false;
			this._GroupBoxSitemap.Text = "Карта сайта (sitemap) в базе";
			// 
			// _ButtonStopLoadSitemap
			// 
			this._ButtonStopLoadSitemap.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonStopLoadSitemap.Location = new System.Drawing.Point(400, 38);
			this._ButtonStopLoadSitemap.Name = "_ButtonStopLoadSitemap";
			this._ButtonStopLoadSitemap.Size = new System.Drawing.Size(75, 23);
			this._ButtonStopLoadSitemap.TabIndex = 4;
			this._ButtonStopLoadSitemap.Text = "Отменить";
			this._ButtonStopLoadSitemap.UseVisualStyleBackColor = true;
			this._ButtonStopLoadSitemap.Click += new System.EventHandler(this._ButtonStopLoadSitemap_Click);
			// 
			// _LabelTotalURLs
			// 
			this._LabelTotalURLs.AutoSize = true;
			this._LabelTotalURLs.Location = new System.Drawing.Point(6, 48);
			this._LabelTotalURLs.Name = "_LabelTotalURLs";
			this._LabelTotalURLs.Size = new System.Drawing.Size(120, 13);
			this._LabelTotalURLs.TabIndex = 3;
			this._LabelTotalURLs.Text = "Всего страниц в базе:";
			// 
			// _ButtonLoadSitemap
			// 
			this._ButtonLoadSitemap.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonLoadSitemap.Location = new System.Drawing.Point(400, 14);
			this._ButtonLoadSitemap.Name = "_ButtonLoadSitemap";
			this._ButtonLoadSitemap.Size = new System.Drawing.Size(75, 23);
			this._ButtonLoadSitemap.TabIndex = 2;
			this._ButtonLoadSitemap.Text = "Загрузить";
			this._ButtonLoadSitemap.UseVisualStyleBackColor = true;
			this._ButtonLoadSitemap.Click += new System.EventHandler(this._ButtonLoadSitemap_Click);
			// 
			// _TextBoxURLSitemap
			// 
			this._TextBoxURLSitemap.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._TextBoxURLSitemap.Location = new System.Drawing.Point(110, 16);
			this._TextBoxURLSitemap.Name = "_TextBoxURLSitemap";
			this._TextBoxURLSitemap.Size = new System.Drawing.Size(284, 20);
			this._TextBoxURLSitemap.TabIndex = 1;
			// 
			// _LabelURL
			// 
			this._LabelURL.AutoSize = true;
			this._LabelURL.Location = new System.Drawing.Point(6, 19);
			this._LabelURL.Name = "_LabelURL";
			this._LabelURL.Size = new System.Drawing.Size(105, 13);
			this._LabelURL.TabIndex = 0;
			this._LabelURL.Text = "Файл карты сайта:";
			// 
			// _BackgroundWorkerSitemapLoad
			// 
			this._BackgroundWorkerSitemapLoad.WorkerReportsProgress = true;
			this._BackgroundWorkerSitemapLoad.WorkerSupportsCancellation = true;
			this._BackgroundWorkerSitemapLoad.DoWork += new System.ComponentModel.DoWorkEventHandler(this._BackgroundWorkerSitemapLoad_DoWork);
			this._BackgroundWorkerSitemapLoad.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this._BackgroundWorkerSitemapLoad_RunWorkerCompleted);
			// 
			// _GroupBoxMainTweeting
			// 
			this._GroupBoxMainTweeting.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._GroupBoxMainTweeting.Controls.Add(this._ButtonStopTweeting);
			this._GroupBoxMainTweeting.Controls.Add(this._ButtonStartTweeting);
			this._GroupBoxMainTweeting.Controls.Add(this._LabelNextPostTime);
			this._GroupBoxMainTweeting.Controls.Add(this._LabelLastPost);
			this._GroupBoxMainTweeting.Location = new System.Drawing.Point(3, 167);
			this._GroupBoxMainTweeting.Name = "_GroupBoxMainTweeting";
			this._GroupBoxMainTweeting.Size = new System.Drawing.Size(481, 114);
			this._GroupBoxMainTweeting.TabIndex = 1;
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
			// _GroupBoxLoadImages
			// 
			this._GroupBoxLoadImages.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this._GroupBoxLoadImages.Controls.Add(this._ButtonLoadImages);
			this._GroupBoxLoadImages.Location = new System.Drawing.Point(3, 85);
			this._GroupBoxLoadImages.Name = "_GroupBoxLoadImages";
			this._GroupBoxLoadImages.Size = new System.Drawing.Size(481, 76);
			this._GroupBoxLoadImages.TabIndex = 2;
			this._GroupBoxLoadImages.TabStop = false;
			this._GroupBoxLoadImages.Text = "Загрузить новые внешние изображения с диска";
			// 
			// _ButtonLoadImages
			// 
			this._ButtonLoadImages.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonLoadImages.Location = new System.Drawing.Point(230, 19);
			this._ButtonLoadImages.Name = "_ButtonLoadImages";
			this._ButtonLoadImages.Size = new System.Drawing.Size(245, 23);
			this._ButtonLoadImages.TabIndex = 0;
			this._ButtonLoadImages.Text = "Загрузить новые изображения с диска";
			this._ButtonLoadImages.UseVisualStyleBackColor = true;
			this._ButtonLoadImages.Click += new System.EventHandler(this._ButtonLoadImages_Click);
			// 
			// _BackgroundWorkerLoadImages
			// 
			this._BackgroundWorkerLoadImages.WorkerReportsProgress = true;
			this._BackgroundWorkerLoadImages.WorkerSupportsCancellation = true;
			this._BackgroundWorkerLoadImages.DoWork += new System.ComponentModel.DoWorkEventHandler(this._BackgroundWorkerLoadImages_DoWork);
			this._BackgroundWorkerLoadImages.RunWorkerCompleted += new System.ComponentModel.RunWorkerCompletedEventHandler(this._BackgroundWorkerLoadImages_RunWorkerCompleted);
			// 
			// SitePagesTweetControl
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.Controls.Add(this._GroupBoxLoadImages);
			this.Controls.Add(this._GroupBoxMainTweeting);
			this.Controls.Add(this._GroupBoxSitemap);
			this.Name = "SitePagesTweetControl";
			this.Size = new System.Drawing.Size(487, 297);
			this.Load += new System.EventHandler(this.SitePagesTweetControl_Load);
			this._GroupBoxSitemap.ResumeLayout(false);
			this._GroupBoxSitemap.PerformLayout();
			this._GroupBoxMainTweeting.ResumeLayout(false);
			this._GroupBoxMainTweeting.PerformLayout();
			this._GroupBoxLoadImages.ResumeLayout(false);
			this.ResumeLayout(false);

		}

		#endregion

		private System.Windows.Forms.GroupBox _GroupBoxSitemap;
		private System.Windows.Forms.Label _LabelURL;
		private System.Windows.Forms.TextBox _TextBoxURLSitemap;
		private System.Windows.Forms.Button _ButtonLoadSitemap;
		private System.Windows.Forms.Label _LabelTotalURLs;
		private System.ComponentModel.BackgroundWorker _BackgroundWorkerSitemapLoad;
		private System.Windows.Forms.Button _ButtonStopLoadSitemap;
		private System.Windows.Forms.GroupBox _GroupBoxMainTweeting;
		private System.Windows.Forms.Button _ButtonStartTweeting;
		private System.Windows.Forms.Label _LabelNextPostTime;
		private System.Windows.Forms.Label _LabelLastPost;
		private System.Windows.Forms.Button _ButtonStopTweeting;
		private System.ComponentModel.BackgroundWorker _BackgroundWorkerTweeting;
		private System.Windows.Forms.GroupBox _GroupBoxLoadImages;
		private System.Windows.Forms.Button _ButtonLoadImages;
		private System.ComponentModel.BackgroundWorker _BackgroundWorkerLoadImages;
	}
}
