using System;
using System.Collections.Generic;
using System.Text;

namespace Templates
{
    public static class Sets
    {
        /// <summary>
        /// Из множества A вычесть множество B. Результат поместить в множество A.
        /// </summary>
        /// <typeparam name="TKey">Тип ключей множеств</typeparam>
        /// <typeparam name="TValue">Тип значений множеств</typeparam>
        /// <param name="a">Множество A.</param>
        /// <param name="b">Множество B.</param>
        /// <returns>Результат A - B.</returns>
        public static void SubtractInto<TKey, TValue1, TValue2>(IDictionary<TKey, TValue1> a, IDictionary<TKey, TValue2> b)
        {
            if ( a == null)
                throw new ArgumentNullException();
            if ( b == null || b.Count == 0 )
                return;
            
            foreach ( KeyValuePair<TKey, TValue2> item in b )
                a.Remove( item.Key );
        }

        /// <summary>
        /// Из множества a вычесть множество b.
        /// </summary>
        /// <typeparam name="T">Тип значений множеств.</typeparam>
        /// <param name="a">Множество a.</param>
        /// <param name="b">Множество b.</param>
        /// <returns>Результат a - b.</returns>
        public static T[] Subtract<T>(IList<T> a, IList<T> b)
        {
            return Subtract(a, b, null);
        }

        /// <summary>
        /// Из множества a вычесть множество b.
        /// </summary>
        /// <typeparam name="T">Тип значений множеств.</typeparam>
        /// <param name="a">Множество a.</param>
        /// <param name="b">Множество b.</param>
        /// <param name="equalityComparer">Детектор идентичности.</param>
        /// <returns>Результат a - b.</returns>
        public static T[] Subtract<T>(IList<T> a, IList<T> b, IEqualityComparer<T> equalityComparer)
        {
            Dictionary<T, object> d = new Dictionary<T, object>(a.Count, equalityComparer);
            for (int i = 0; i < a.Count; i++)
                d.Add(a[i], null);
            for (int i = 0; i < b.Count; i++)
                d.Remove(b[i]);
            return Sets.GetKeyArray(d);
        }

        public static void SubtractInto<TKey, TValue>(IDictionary<TKey, TValue> a, IList<TKey> b)
        {
            if (a == null)
                throw new ArgumentNullException("a");
            if (b == null)
                return;

            foreach (TKey item in b)
                a.Remove(item);
        }

        public static bool Equals<T>(IList<T> a, IList<T> b)
        {
            return _InternalEquals<T>(a, b, null);
        }

        public static bool Equals<T>(IList<T> a, IList<T> b, IEqualityComparer<T> equalityComparer)
        {
            return _InternalEquals<T>(a, b, equalityComparer);
        }

        public static bool Equals<T>(IList<T[]> a, IList<T[]> b)
        {
            return _InternalEquals(a, b, Arrays.EqualityComparer<T>.Instance);
        }

        public static bool Equals<T>(IList<T[]> a, IList<T[]> b, IEqualityComparer<T> elementEqualityComparer)
        {
            return _InternalEquals(a, b, new Arrays.EqualityComparer<T>(elementEqualityComparer));
        }

        public static bool KeysEquals<TKey, TValue1, TValue2>(
            IDictionary<TKey, TValue1> a,
            IDictionary<TKey, TValue2> b)
        {
            if (object.ReferenceEquals(a, b))
                return true;
            if (a == null ||
                b == null ||
                a.Count != b.Count)
                return false;

            foreach (KeyValuePair<TKey, TValue1> item in a)
            {
                if (!b.ContainsKey(item.Key))
                    return false;
            }

            return true;
        }

        static bool _InternalEquals<T>(
            IList<T> list1,
            IList<T> list2,
            IEqualityComparer<T> equalityComparer)
        {
            if (IList<T>.ReferenceEquals(list1, list2))
                return true;

            if (list1 == null ||
                list2 == null ||
                list1.Count != list2.Count)
            {
                return false;
            }

            for (int i = 0; i < list1.Count; i++)
            {
                if (equalityComparer != null)
                {
                    if (!equalityComparer.Equals(list1[i], list2[i]))
                        return false;
                }

                if (!list1[i].Equals(list2[i]))
                    return false;
            }

            return true;
        }

        private static Dictionary<T, int> _CreateValuesCountMap<T>(
            IList<T> list,
            IEqualityComparer<T> equalityComparer)
        {
            Dictionary<T, int> map = new Dictionary<T, int>(list.Count, equalityComparer);
            for (int i = 0; i < list.Count; i++)
            {
                int valuesCount;
                if (map.TryGetValue(list[i], out valuesCount))
                    map[list[i]] = valuesCount + 1;
                else
                    map[list[i]] = 1;
            }
            return map;
        }

        public static void FillDictionary<TKey, TValue>( 
                                    IDictionary<TKey, TValue> dictionary,
                                    IDictionary<TKey, TValue> sourceDictionary)
        {
            if ( dictionary == null )
                throw new ArgumentNullException( "dictionary" );

            if ( sourceDictionary == null )
                throw new ArgumentNullException( "sourceDictionary" );
            
            foreach ( var item in sourceDictionary )
                dictionary[item.Key] = item.Value;
        }

        public static void FillDictionary<TKey, TValue>(IDictionary<TKey, TValue> dictionary,
                                                        IList<TKey> keys,
                                                        IList<TValue> values)
        {
            if (dictionary == null)
                throw new ArgumentNullException("dictionary");
            if (keys == null)
                return;
            if (values != null &&
                keys.Count != values.Count)
                throw new ArgumentNullException("keys.Count != values.Count");

            for (int i = 0; i < keys.Count; i++)
                dictionary[keys[i]] = values == null ? default(TValue) : values[i];
        }

        public static void FillDictionary<TKey, TValue>(
            IDictionary<TKey, TValue> dictionary,
            IList<TKey> keys)
        {
            if (dictionary == null)
                throw new ArgumentNullException("dictionary");
            if (keys == null)
                throw new ArgumentNullException("keys");
            for (int i = 0; i < keys.Count; i++)
                dictionary[keys[i]] = default(TValue);
        }

        public static Dictionary<TKey, TValue> CreateDictionary<TKey, TValue>(
            IList<TKey> keys,
            IList<TValue> values,
            IEqualityComparer<TKey> equalityComparer)
        {
            if (keys == null)
                return new Dictionary<TKey, TValue>(equalityComparer);

            Dictionary<TKey, TValue> result = new Dictionary<TKey, TValue>(keys.Count, equalityComparer);
            FillDictionary(result, keys, values);
            return result;
        }

        public static Dictionary<TKey, object> CreateDictionary<TKey>(IList<TKey> keys)
        {
            return CreateDictionary<TKey>(keys, null);
        }

        public static Dictionary<TKey, object> CreateDictionary<TKey>(
            IList<TKey> keys,
            IEqualityComparer<TKey> equalityComparer)
        {
            return CreateDictionary<TKey, object>(keys, null, equalityComparer);
        }

        public static bool Intersects<T, T2>(IDictionary<T, T2> a, IDictionary<T, T2> b)
        {
            foreach (KeyValuePair<T, T2> item in a)
            {
                if (b.ContainsKey(item.Key))
                    return true;
            }
            return false;
        }
        
        public static bool IsFullIntersects<T, T2>(IDictionary<T, T2> a, IDictionary<T, T2> b)
        {
            foreach (KeyValuePair<T, T2> item in a)
            {
                if (!b.ContainsKey(item.Key))
                    return false;
            }
            return true;
        }

        public static bool Intersects<T>(IList<T> a, IList<T> b, IEqualityComparer<T> equalityComparer)
        {
            Dictionary<T, object> d = CreateDictionary(a, equalityComparer);
            foreach (T bi in b)
                if (d.ContainsKey(bi))
                    return true;
            return false;
        }

        public static List<T> Intersect<T>(
            IList<T> a,
            IList<T> b,
            IEqualityComparer<T> equalityComparer)
        {
            List<T> r = new List<T>(Algorithms.Max(a.Count, b.Count));
            Dictionary<T, object> d = CreateDictionary(a, equalityComparer);
            foreach (T bi in b)
                if (d.ContainsKey(bi))
                    r.Add(bi);
            return r;
        }

        public static void IntersectInto<TKey, TValue1, TValue2>(
            IDictionary<TKey, TValue1> into,
            IDictionary<TKey, TValue2> from)
        {
            if (into == null)
                throw new ArgumentNullException("into");

            if (from == null ||
                from.Count == 0)
            {
                into.Clear();
                return;
            }

            List<TKey> excludes = new List<TKey>(from.Count);
            foreach (KeyValuePair<TKey, TValue1> item in into)
            {
                if (!from.ContainsKey(item.Key))
                    excludes.Add(item.Key);
            }
            foreach (TKey item in excludes)
                into.Remove(item);
        }

        public static List<T> Intersect<T>(
            IList<T> a,
            IList<T> b)
        {
            return Intersect(a, b, null);
        }

        public static TKey[] GetKeyArray<TKey, TValue>(IDictionary<TKey, TValue> dictionary)
        {
            TKey[] keys = new TKey[dictionary.Count];
            dictionary.Keys.CopyTo(keys, 0);
            return keys;
        }

        public static TValue[] GetValueArray<TKey, TValue>(IDictionary<TKey, TValue> dictionary)
        {
            TValue[] values = new TValue[dictionary.Count];
            dictionary.Values.CopyTo(values, 0);
            return values;
        }
    }
}
