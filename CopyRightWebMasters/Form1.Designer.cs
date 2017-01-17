namespace CopyRightWebMasters
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
			this._ButtonStart = new System.Windows.Forms.Button();
			this.label1 = new System.Windows.Forms.Label();
			this.SuspendLayout();
			// 
			// _ButtonStart
			// 
			this._ButtonStart.Anchor = ((System.Windows.Forms.AnchorStyles)((System.Windows.Forms.AnchorStyles.Bottom | System.Windows.Forms.AnchorStyles.Right)));
			this._ButtonStart.Location = new System.Drawing.Point(345, 147);
			this._ButtonStart.Name = "_ButtonStart";
			this._ButtonStart.Size = new System.Drawing.Size(112, 23);
			this._ButtonStart.TabIndex = 0;
			this._ButtonStart.Text = "Start";
			this._ButtonStart.UseVisualStyleBackColor = true;
			this._ButtonStart.Click += new System.EventHandler(this._ButtonStart_Click);
			// 
			// label1
			// 
			this.label1.Anchor = ((System.Windows.Forms.AnchorStyles)(((System.Windows.Forms.AnchorStyles.Top | System.Windows.Forms.AnchorStyles.Left) 
            | System.Windows.Forms.AnchorStyles.Right)));
			this.label1.Location = new System.Drawing.Point(12, 9);
			this.label1.Name = "label1";
			this.label1.Size = new System.Drawing.Size(445, 56);
			this.label1.TabIndex = 1;
			this.label1.Text = "Из файла source.htm извлекает ссылки на сайт, которые были блокированы, и формиру" +
    "ет результат-массив для js";
			// 
			// Form1
			// 
			this.AutoScaleDimensions = new System.Drawing.SizeF(6F, 13F);
			this.AutoScaleMode = System.Windows.Forms.AutoScaleMode.Font;
			this.ClientSize = new System.Drawing.Size(469, 182);
			this.Controls.Add(this.label1);
			this.Controls.Add(this._ButtonStart);
			this.Name = "Form1";
			this.Text = "Извлечение ссылок из сообщения WebMasters";
			this.ResumeLayout(false);

		}

		#endregion

		private System.Windows.Forms.Button _ButtonStart;
		private System.Windows.Forms.Label label1;
	}
}

