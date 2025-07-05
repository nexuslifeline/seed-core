import applyConverters from 'axios-case-converter';
import axios from 'axios';
import Token from '@lib/token';

const baseURL = `${import.meta.env.VITE_API_BASE_URL}/${
  import.meta.env.VITE_API_PREFIX
}/`;

const apiClient = applyConverters(
  axios.create({
    baseURL,
    headers: {
      Accept: 'application/json',
      'Content-Type': 'application/json'
    }
  })
);

apiClient.interceptors.request.use((request) => {
  const token = Token.get();

  if (token) {
    request.headers['Authorization'] = `Bearer ${token}`;
  }

  return request;
});

apiClient.interceptors.response.use(
  (response) => response,
  (error) => {
    const { message } = error;
    const { status, data } = error.response;
    const { method, url } = error.config;

    if (status === 401) {
      // Replace the following line with your actual redirect logic
      window.location.replace('/login');

      // Resolve the promise with a specific value indicating the redirect
      return Promise.resolve('Redirected to login page');
    }

    console.log(
      `API [${method?.toUpperCase()}] ${url} | Error ${status} ${
        data?.message || ''
      } | ${message}`,
      error
    );
    // Continue rejecting the promise with the original error object
    return Promise.reject(error);
  }
);

export default apiClient;
