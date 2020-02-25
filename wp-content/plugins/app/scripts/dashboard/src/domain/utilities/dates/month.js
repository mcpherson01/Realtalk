function month(monthNumber) {
    return month.months[parseInt(monthNumber) - 1];
}

month.months = [
    "January", 
    "February", 
    "March", 
    "April", 
    "May", 
    "June",
    "July", 
    "August", 
    "September", 
    "October", 
    "November", 
    "December"
];

export {month};