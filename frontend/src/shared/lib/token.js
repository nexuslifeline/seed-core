const tokenKey = 'tenant-token';

class Token {
  get() {
    return localStorage.getItem(tokenKey);
  }

  set(token) {
    localStorage.setItem(tokenKey, token);
  }

  remove() {
    localStorage.removeItem(tokenKey);
  }
}

export default new Token();
