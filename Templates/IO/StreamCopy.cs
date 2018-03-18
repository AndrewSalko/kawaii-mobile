using System;
using System.Collections.Generic;
using System.Text;

namespace Templates.IO
{
    public static class StreamCopy
    {
        public static void Copy(System.IO.Stream source, System.IO.Stream destination, int bufferSize)
        {
			bool sourceStreamCanSeek = false;

			try
			{
				sourceStreamCanSeek = source.CanSeek;
			}
			catch
			{
			}

			if (sourceStreamCanSeek)
			{
				long sourceStreamLength = 0;

				try
				{
					sourceStreamLength = source.Length;

					bufferSize = (int)Math.Min((long)bufferSize, sourceStreamLength);

					if (sourceStreamLength > bufferSize && sourceStreamLength > (1024 * 1024 * 5))
					{
						long newBufferSize = sourceStreamLength / 20;
						bufferSize = Math.Max(bufferSize, (int)newBufferSize);
					}
				}
				catch (NotSupportedException)
				{
				}
			}

            byte[] buffer = new byte[bufferSize];
            for (; ; )
            {
                int r = source.Read(buffer, 0, bufferSize);
                if (r == 0)
                    break;
                destination.Write(buffer, 0, r);
            }
        }

        public static void Copy(System.IO.Stream source, System.IO.Stream destination)
        {
            Copy(source, destination, 32768);
        }
    }
}
