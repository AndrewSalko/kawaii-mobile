using System;
using System.Collections.Generic;
using System.Text;

namespace WallpaperImages
{
	class ImageFile
	{
		string _FullName = null;
		
		public ImageFile(string fileName)
		{
			_FullName = fileName;
			
		}

		public string Name
		{
			get
			{
				string name = System.IO.Path.GetFileName(_FullName);
				return name;
			}
		}
		
		public string FullName
		{
			get
			{
				return _FullName;
			}
			set
			{
				_FullName = value;
			}
		}

		public override string ToString()
		{
			return Name;
		}

		public void Rename(string newFileName)
		{
			string pathToFile = System.IO.Path.GetDirectoryName(FullName);
			string newFullName = System.IO.Path.Combine(pathToFile, newFileName);

			System.IO.File.Move(FullName, newFullName);

			FullName = newFullName;
		}

	}
}
