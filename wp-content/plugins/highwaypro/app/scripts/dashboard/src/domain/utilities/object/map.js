export function map(object: object, callable) {
    const newArray = [];

    for (let key in object) {
        newArray.push(callable(object[key], key));
    }

    return newArray;
}