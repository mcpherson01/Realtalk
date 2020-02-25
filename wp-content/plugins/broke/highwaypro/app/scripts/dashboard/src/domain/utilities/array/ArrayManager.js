export class ArrayManager
{
    static intersect(firstArray, secondArray)
    {
        return firstArray.filter(value => secondArray.includes(value));
    }

    static difference(firstArray, secondArray)
    {
        return firstArray.filter(value => !secondArray.includes(value));
    }
}