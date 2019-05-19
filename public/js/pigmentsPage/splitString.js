function splitString(stringToSplit, separator) {
    var arrayOfStrings = stringToSplit.split(separator);

    console.log('Оригинальная строка: "' + stringToSplit + '"');
    console.log('Разделитель: "' + separator + '"');
    console.log('Массив содержит ' + arrayOfStrings.length + ' элементов: ' + arrayOfStrings.join(' / '));

    return arrayOfStrings;
}