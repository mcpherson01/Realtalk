import { isObject } from './isObject';

export const clone = object => {
    if (isObject(object)) {
        return Object.assign({}, object);
    } else {
        return object.slice(0);
    }
}