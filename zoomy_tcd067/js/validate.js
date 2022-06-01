/**
 * パスワードのフォーマットを確認
 * @param {string=} passwordVal パスワード
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validatePassword(passwordVal) {
    // 半角英小文字、大文字、数字を含む9文字以上32文字以内であればtrueを返す
    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*?[0-9])[a-zA-Z0-9]{9,32}$/.test(passwordVal);
}

/**
 * メールアドレスのフォーマットを確認
 * @param {string=} emailVal メールアドレス
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateEmail(emailVal) {
    // メールアドレス形式の場合trueを返す
    
    return /^[A-Za-z0-9]{1}[A-Za-z0-9_.-]*@{1}[A-Za-z0-9_-]{1,}\.[A-Za-z0-9]{1,}\.{0,1}[A-Za-z0-9]{1,}$/.test(emailVal);
}

/**
 * URLのフォーマットを確認
 * @param {string=} urlVal URL
 * @returns {boolean} フォーマットが正しい場合はtrueを返す
 */
function validateUrl(urlVal) {
    // URL形式の場合trueを返す
    
    return /^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/.test(urlVal);
}
