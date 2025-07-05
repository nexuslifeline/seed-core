import apiClient from '@api/apiClient';

export const loginUser = (data, config) => {
  return apiClient.post(`login`, data, config);
};

export const logout = (config) => {
  return apiClient.post(`logout`, {}, config);
};

export const resetPassword = (data, config) => {
  return apiClient.post(`password/reset`, data, config);
};

export const sendResetLink = (data, config) => {
  return apiClient.post(`password/send-reset-link`, data, config);
};

export const registerTenantUser = (data, config) => {
  return apiClient.post(`register`, data, config);
};

export const resendEmailVerification = (config) => {
  return apiClient.get(`email/verify/resend`, config);
};

export const verifyEmail = (token, config) => {
  return apiClient.get(`email/verify/${token}`, config);
};

export const getMe = (config) => {
  return apiClient.get(`me`, config);
};
