using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace SalkoDev.KawaiiTwitter
{
	/// <summary>
	/// Интерфейс для постов сайта и gif-изображений вне сайта
	/// </summary>
	interface ITwittable
	{
		/// <summary>
		/// Есть ли файл-изображение для поста. Если нет - пропустить это
		/// </summary>
		bool HasImage
		{
			get;
		}
		
		/// <summary>
		/// Полный путь к файлу-изображению (уже скачано, на лок.диске)
		/// </summary>
		string ImageFileName
		{
			get;
		}

		/// <summary>
		/// Вернет текст, который должен войти в твит
		/// </summary>
		/// <returns>Текст для твита</returns>
		string CreateTwitterText();

		/// <summary>
		/// Дата твита (когда твит сделан, ее установят извне)
		/// </summary>
		DateTime? TweetDate
		{
			get;
			set;
		}

		string Title
		{
			get;
			set;
		}
	}
}
