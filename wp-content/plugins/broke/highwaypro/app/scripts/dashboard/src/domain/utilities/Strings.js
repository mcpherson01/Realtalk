export class Strings
{
    static ensureLeadingPath = (value) => {
        if (!value) {
            return value;
        }
        if (value.charAt(0) !== '/') {
            return `/${value}`;
        }

        return value;
    }

    static lcfirst = (_string) =>
    {
        return _string.charAt(0).toLowerCase() + _string.substring(1);
    }

    static ucfirst = (_string) =>
    {
        return _string.charAt(0).toUpperCase() + _string.substring(1);
    }

    static explodeByNewLine = (_string) =>
    {
        return _string.split("\n");
    }
}