export class Callable
{
    static callAndReturnArgument(callable) {
        return (argument) => {
            callable(argument);

            return argument;
        }
    }
}