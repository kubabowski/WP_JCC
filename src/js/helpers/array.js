/**
 * iterates through array items, call the function for each of them
 * @param {array} array array of items
 * @param {function} callback function to call for each item
 * @info break - return the false value to break the loop
 * @info continue - return the true value to skip current item
 */
export function each(array, callback) {
  const l = array.length;
  for (let i = 0; i < l; i++) {
    const result = callback(array[i], i);
    if (result === false) break;
    if (result === true) continue;
  }
}

/**
 * iterates through array items, map each of them
 * @param {array} array array of items
 * @param {function} callback mapping function for each item
 * @returns {array} array of mapped items
 */
export function mapEach(array, callback) {
  const resultArr = [];
  const l = array.length;
  for (let i = 0; i < l; i++) {
    resultArr[i] = callback(array[i], i);
  }
  return resultArr;
}

export default {
  each,
  mapEach,
};
