using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace WallpaperImages
{
	class HTMLTemplateBase
	{
		string _Template;

		public HTMLTemplateBase(string resolutionName, string fileName)
		{
			ResolutionName = resolutionName;
			FileName = fileName;
			_Template = System.IO.File.ReadAllText(FileName);
		}

		public string Template
		{
			get
			{
				return _Template;
			}
		}

		public string ResolutionName
		{
			get;
			set;
		}

		public string FileName
		{
			get;
			set;
		}

	}
}
