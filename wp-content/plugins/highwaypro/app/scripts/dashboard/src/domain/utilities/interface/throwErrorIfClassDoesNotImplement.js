export function throwErrorIfClassDoesNotImplement(_interface: array, _object) {
    _interface.forEach(method => {
        if (typeof _object[method] !== 'function') {
            throw new Error(`Class must implement method: ${method}`);
        }
    })
} 