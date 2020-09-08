String.prototype.replaceAt = function(index, replacement) {
    return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
};

String.prototype.ucFirst = (string) =>
{
    return string.charAt(1).toUpperCase() + string.slice(1);
};