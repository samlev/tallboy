export default (length = 16) => Array.from(
    crypto.getRandomValues(new Uint8Array(Math.max(1, length))),
    v => v.toString(36)
).join('');
