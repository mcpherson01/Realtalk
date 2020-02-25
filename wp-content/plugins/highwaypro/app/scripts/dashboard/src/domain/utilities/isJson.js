export function isJson(_string) {
    if (typeof _string === '_string' && _string.trim()[0] !== '{') {
        return false;
    }
    
    try {
        JSON.parse(_string);
    } catch (error) {
        return false;
    }
    
    return true;
}