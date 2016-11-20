using System;
using System.Collections.Generic;
using System.Linq;
using System.Text;

namespace SalkoDev.KawaiiTwitter
{
	interface ILog: IDisposable
	{		
		void Log(string format, params object[] args);
	}
}
