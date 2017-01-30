using System;
using System.Collections.Generic;
using System.IO;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace WallpaperImages
{
	class PageCompose
	{
		const string TEMPLATESDIR = "Templates";

		const string FILE_NAME_HEADER = "header";
		const string FILE_NAME_BODY = "body";

		Dictionary<string, object> _Resolutions = new Dictionary<string, object>(StringComparer.CurrentCultureIgnoreCase);

		/// <summary>
		/// Разрешение на класс шаблона
		/// </summary>
		Dictionary<string, List<HTMLTemplateBody>> _BodyTemplates = new Dictionary<string, List<HTMLTemplateBody>>(StringComparer.CurrentCultureIgnoreCase);

		/// <summary>
		/// Разрешение на класс шаблона
		/// </summary>
		Dictionary<string, List<HTMLTemplateHeader>> _HeaderTemplates = new Dictionary<string, List<HTMLTemplateHeader>>(StringComparer.CurrentCultureIgnoreCase);

		string _AnimeName;

		public PageCompose(string animeName)
		{
			_AnimeName = animeName;
			_LoadTemplates();
		}

		void _LoadTemplates()
		{
			string templatesDir = Path.Combine(Application.StartupPath, TEMPLATESDIR);
			//получаем все подпапки, имя папки - это разрешение экрана

			DirectoryInfo dir = new DirectoryInfo(templatesDir);
			var subDirs=dir.GetDirectories();
			if (subDirs != null)
			{
				foreach (var resolDir in subDirs)
				{
					string resolutionName = resolDir.Name;

					//получаем файлы:
					var files=resolDir.GetFiles();
					if (files != null)
					{
						foreach (var fileTemplate in files)
						{
							string fullFileName = fileTemplate.FullName;
							string fileName = fileTemplate.Name;

							if (fileName.Contains(FILE_NAME_HEADER))
							{
								_Resolutions[resolutionName] = null;
								HTMLTemplateHeader headerTemplate = new HTMLTemplateHeader(resolutionName, fullFileName);

								List<HTMLTemplateHeader> headList;
								if (!_HeaderTemplates.TryGetValue(resolutionName, out headList))
								{
									headList = new List<HTMLTemplateHeader>();
									_HeaderTemplates[resolutionName] = headList;
								}

								headList.Add(headerTemplate);								
							}
							else
							{
								if (fileName.Contains(FILE_NAME_BODY))
								{
									_Resolutions[resolutionName] = null;
									HTMLTemplateBody bodyTemplate = new HTMLTemplateBody(resolutionName, fullFileName);

									List<HTMLTemplateBody> bodyList;
									if (!_BodyTemplates.TryGetValue(resolutionName, out bodyList))
									{
										bodyList = new List<HTMLTemplateBody>();
										_BodyTemplates[resolutionName] = bodyList;
									}

									bodyList.Add(bodyTemplate);																		
								}
							}														
						}
					}

				}
			}//subDirs

		}//_LoadTemplates


		public string[] Resolutions 
		{
			get
			{
				string[] result =new string[_Resolutions.Count];

				int i = 0;
				foreach (var item in _Resolutions)
				{
					result[i] = item.Key;
					i++;
				}

				return result;
			}
		}

		/// <summary>
		/// Получить HTML-тело поста
		/// </summary>
		/// <param name="resolutions">Массив разрешений</param>
		/// <param name="wikiLink">Ссылка на англ википедию</param>
		/// <param name="genreText">Жанр</param>
		/// <param name="useHTMLTableFormat">Оформить тело поста в виде HTML таблицы</param>
		/// <param name="addReviewBlock">Добавить блок обзора (review)</param>
		/// <returns></returns>
		public string GetHTML(string[] resolutions, string wikiLink, string genreText, bool useHTMLTableFormat, bool addReviewBlock)
		{
			string result = string.Empty;

			if (resolutions == null || resolutions.Length == 0)
				return result;

			Random rnd = new Random(Environment.TickCount);
			
			List<string> bodiesHTML=new List<string>();

			if(addReviewBlock)
			{
				result += "<p><a href=\"#review\">Review</a></p>" + Environment.NewLine;
			}

			foreach (var res in resolutions)
			{
				List<HTMLTemplateHeader> heads;
				List<HTMLTemplateBody> bodies;

				if (!_HeaderTemplates.TryGetValue(res, out heads))
				{
					throw new ApplicationException("Не найден head-шаблон для разрешения:"+res);
				}

				if (!_BodyTemplates.TryGetValue(res, out bodies))
				{
					throw new ApplicationException("Не найден body-шаблон для разрешения:" + res);
				}

				int indexHead = rnd.Next(0, heads.Count);
				int indexBody = rnd.Next(0, bodies.Count);

				string head = string.Format(heads[indexHead].Template, _AnimeName);
				string body = string.Format(bodies[indexBody].Template, _AnimeName);

				result += head;
				result += Environment.NewLine;
				
				bodiesHTML.Add(body);
			}

			if (useHTMLTableFormat)
			{
				result += "<table border=\"0\" width=\"100%\">" + Environment.NewLine;
				result += "<tbody>" + Environment.NewLine;
			}

			if(addReviewBlock)
			{
				result += "<tr>" + Environment.NewLine;
				result += "<td>" + Environment.NewLine;

				result += "<a name=\"review\"></a>" + Environment.NewLine;
				result += string.Format("<h2>{0} Review</h2>", _AnimeName) + Environment.NewLine;

				result += "</td>" + Environment.NewLine;
				result += "</tr>" + Environment.NewLine;
			}

			//добавляем блоки шаблонов внутри:
			foreach (var item in bodiesHTML)
			{
				if (useHTMLTableFormat)
				{
					result += "<tr>" + Environment.NewLine;
					result += "<td>" + Environment.NewLine;
				}

				result += item + Environment.NewLine;

				if (useHTMLTableFormat)
				{					
					result += "</td>" + Environment.NewLine;
					result += "</tr>" + Environment.NewLine;
				}		
			}

			if (useHTMLTableFormat)
			{
				result += "</tbody>" + Environment.NewLine;
				result += "</table>" + Environment.NewLine;				
			}

			if (!string.IsNullOrWhiteSpace(genreText))
			{
				result += "<p>Genre: " + genreText + "</p>";
			}
			result += Environment.NewLine;

			if (!string.IsNullOrWhiteSpace(wikiLink))
			{
				string linkTemplate = "<a href=\"{0}\" rel=\"nofollow\" target=\"_blank\">{1} on Wikipedia</a>";
				result += string.Format(linkTemplate, wikiLink, _AnimeName);
			}

			return result;
		}
	}
}
