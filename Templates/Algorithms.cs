using System;
using System.Collections.Generic;
using System.Text;

namespace Templates
{
    public static class Algorithms
    {
        public static void Swap<T>(ref T a, ref T b)
        {
            T c = a;
            a = b;
            b = c;
        }

        public static T Max<T>(T a, T b) where T : IComparable<T>
        {
            return a.CompareTo(b) > 0 ? a : b;
        }

        public static T Min<T>(T a, T b) where T : IComparable<T>
        {
            return a.CompareTo(b) < 0 ? a : b;
        }

        public static T Max<T>(T a, T b, params T[] c) where T : IComparable<T>
        {
            T max = Max(a, b);
            for (int i = 0; i < c.Length; i++)
                max = Max(max, c[i]);
            return max;
        }

        public static T Min<T>(T a, T b, params T[] c) where T : IComparable<T>
        {
            T min = Min(a, b);
            for (int i = 0; i < c.Length; i++)
                min = Min(min, c[i]);
            return min;
        }
    }
}
