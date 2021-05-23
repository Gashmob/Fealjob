/*
 * Fichier contenant les actions possibles par un visiteur
 */

// Tronque les descriptions
const MAX_DESCRIPTION_LENGTH = 300;

function truncate(str, n, useWordBoundary
) {
    if (str.length <= n) {
        return str;
    }
    const subString = str.substr(0, n - 1); // the original check
    return (useWordBoundary
        ? subString.substr(0, subString.lastIndexOf(" "))
        : subString) + " &hellip;";
};