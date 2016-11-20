using System;
using System.Collections.Generic;
using System.Text;

namespace Templates
{
    public abstract class Disposable : IDisposable
    {
        ~Disposable()
        {
            Dispose(false);
        }

        #region IDisposable Members

        public void Dispose()
        {
            Dispose(true);
            GC.SuppressFinalize(this);
        }

        #endregion

        protected virtual void Dispose(bool disposing)
        {
        }

        public static bool TryDisposeAndClearUnknown<T>(ref T unknown)
        {
            if (unknown != null)
            {
                IDisposable disposable = unknown as IDisposable;
                if (disposable != null)
                    disposable.Dispose();
                unknown = default(T);
                return true;
            }
            return false;
        }

        public static bool TryDispose(IDisposable disposable)
        {
            if (disposable == null)
                return false;
            disposable.Dispose();
            return true;
        }

        public static bool TryDisposeAndClear<T>(ref T disposable) where T : IDisposable
        {
            if (disposable == null)
                return false;
            DisposeAndClear(ref disposable);
            return true;
        }

        public static void DisposeAndClear<T>(ref T disposable) where T : IDisposable
        {
            disposable.Dispose();
            disposable = default(T);
        }
    }
}
