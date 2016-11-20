using System;
using System.Collections.Generic;
using System.Text;

namespace Templates
{
    public static class Arrays
    {
        /// <summary>
        /// Добавить в конец массива d элементы массива s, которых не было в массиве d.
        /// </summary>
        /// <typeparam name="T">Тип элементов массивов.</typeparam>
        /// <param name="d">Массив d, в который будут добавляться элементы.</param>
        /// <param name="s">Массив s, из которого будут добавляться элементы в конец массива d.</param>
        static public void Merge<T>(ref T[] d, T[] s)
        {
            Merge(ref d, s, null);
        }

        /// <summary>
        /// Добавить в конец массива d элементы массива s, которых не было в массиве d.
        /// </summary>
        /// <typeparam name="T">Тип элементов массива.</typeparam>
        /// <param name="d">Массив d, в который будут добавляться элементы.</param>
        /// <param name="s">Массив s, из которого будут добавляться элементы в конец массива d.</param>
        /// <param name="equalityComparer">Детектор идентичности элементов массивов.</param>
        static public void Merge<T>(ref T[] d, T[] s, IEqualityComparer<T> equalityComparer)
        {
            if (s == null || s.Length == 0)
                return;

            if (d == null || d.Length == 0)
            {
                d = s;
                return;
            }

            Dictionary<T, object> sortedSource = new Dictionary<T, object>(s.Length, equalityComparer);

            for (int i = 0; i < s.Length; i++)
                sortedSource[s[i]] = null;

            List<T> result = new List<T>(s.Length + d.Length);
            result.AddRange(s);

            for (int i = 0; i < d.Length; i++)
            {
                if (sortedSource.ContainsKey(d[i]))
                    continue;
                result.Add(d[i]);
            }
            d = result.ToArray();
        }

        /// <summary>
        /// Сравнить два массива по содержанию.
        /// </summary>
        /// <typeparam name="T">Тип элементов массивов.</typeparam>
        /// <param name="a">Массив a.</param>
        /// <param name="b">Массив b.</param>
        /// <returns>Истина - массивы равны по содержанию; ложь - не равны.</returns>
        public static bool Equals<T>(IList<T> a, IList<T> b) where T : IEquatable<T>
        {
            if (IList<T>.ReferenceEquals(a, b))
                return true;
            if (a == null || b == null || a.Count != b.Count)
                return false;

            for (int i = 0; i < a.Count; i++)
            {
                if (!a[i].Equals(b[i]))
                    return false;
            }

            return true;
        }

        /// <summary>
        /// Перекрытие метода сравнения объектов для генерации предупреждения при сборке.
        /// </summary>
        /// <param name="a">Первый объект для сравнения.</param>
        /// <param name="b">Второй объект для сравнения.</param>
        /// <returns>
        /// <code>true</code> если a - тот же экземляр, что и b, если a и b равны, или если a и b равны <code>null</code>.
        /// Иначе, <code>false</code>.</returns>
        [Obsolete]
        public static new bool Equals(object a, object b)
        {
            return object.Equals(a, b);
        }

        /// <summary>
        /// Сравнить два массива по содержанию.
        /// </summary>
        /// <typeparam name="T">Тип элементов массивов.</typeparam>
        /// <param name="a">Массив a.</param>
        /// <param name="b">Массив b.</param>
        /// <param name="equalityComparer">Детектор идентичности.</param>
        /// <returns>Истина - массивы равны по содержанию; ложь - не равны.</returns>
        public static bool Equals<T>(IList<T> a, IList<T> b, IEqualityComparer<T> equalityComparer)
        {
            if (IList<T>.ReferenceEquals(a, b))
                return true;
            if (a == null || b == null || a.Count != b.Count)
                return false;

            if (equalityComparer == null)
                equalityComparer = System.Collections.Generic.EqualityComparer<T>.Default;

            for (int i = 0; i < a.Count; i++)
            {
                if (!equalityComparer.Equals(a[i], b[i]))
                    return false;
            }

            return true;
        }

        /// <summary>
        /// Возвращает массив уникальных значений. Порядок при этом теряется.
        /// </summary>
        /// <typeparam name="T">Тип значений исходного массива.</typeparam>
        /// <param name="source">Исходный массив.</param>
        /// <returns>Массив уникальных значений.</returns>
        public static T[] Uniquize<T>(T[] source)
        {
            return Uniquize(source, null);
        }

        /// <summary>
        /// Возвращает массив уникальных значений. Порядок при этом теряется.
        /// </summary>
        /// <typeparam name="T">Тип значений исходного массива.</typeparam>
        /// <param name="source">Исходный массив.</param>
        /// <param name="equalityComparer">Детектор идентичности элементов массива.</param>
        /// <returns>Массив уникальных значений.</returns>
        public static T[] Uniquize<T>(T[] source, IEqualityComparer<T> equalityComparer)
        {
            Dictionary<T, object> uniqueSet = Sets.CreateDictionary<T, object>(source, null, equalityComparer);
            if (uniqueSet.Count == source.Length)
                return source;

            return Sets.GetKeyArray(uniqueSet);
        }

        /// <summary>
        /// Добавляет элементы в массив.
        /// </summary>
        /// <typeparam name="T">Тип элементов массива.</typeparam>
        /// <param name="array">Массив.</param>
        /// <param name="values">Значения.</param>
        public static void AddRange<T>(ref T[] array, params T[] values)
        {
            int oldSourceSize = array.Length;
            Array.Resize(ref array, oldSourceSize + values.Length);
            for (int i = 0; i < values.Length; i++)
                array[oldSourceSize + i] = values[i];
        }

        /// <summary>
        /// Удаляет элемент с заданным индексом из массива.
        /// </summary>
        /// <typeparam name="T">Тип элементов массива.</typeparam>
        /// <param name="array">Массив.</param>
        /// <param name="index">Индекс удаляемого элемента.</param>
        public static void Remove<T>(ref T[] array, int index)
        {
            if (array == null ||
                index < 0 ||
                index >= array.Length)
                return;

            if (index < array.Length - 1)
            {
                for (int i = index; i < array.Length - 1; i++)
                    array[i] = array[i + 1];
            }

            Array.Resize(ref array, array.Length - 1);
        }

        /// <summary>
        /// Детектор идентичности массивов.
        /// </summary>
        [Serializable]
        public class EqualityComparer<T> : IEqualityComparer<T[]>
        {
            IEqualityComparer<T> _ElementEqualityComparer;

            public EqualityComparer()
            {
            }

            /// <summary>
            /// Конструктор.
            /// </summary>
            /// <param name="elementEqualityComparer">Детектор идентичности элементов массивов.</param>
            public EqualityComparer(IEqualityComparer<T> elementEqualityComparer)
            {
                _ElementEqualityComparer = elementEqualityComparer;
            }

            #region IEqualityComparer<T> Members

            public bool Equals(T[] x, T[] y)
            {
                return Arrays.Equals(x, y, _ElementEqualityComparer);
            }

            public int GetHashCode(T[] obj)
            {
                // TODO: правильно?
                return obj.GetHashCode();
            }

            #endregion

            public static readonly EqualityComparer<T> Instance = new EqualityComparer<T>();
        }
    }
}
