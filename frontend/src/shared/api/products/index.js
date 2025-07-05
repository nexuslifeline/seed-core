import apiClient from '@api/apiClient';

export const postProduct = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/products`, data, config);
};

export const putProduct = (orgUuid, uuid, data, config) => {
  return apiClient.put(`organizations/${orgUuid}/products/${uuid}`, data, config);
};

export const patchProduct = (orgUuid, uuid, data, config) => {
  return apiClient.patch(`organizations/${orgUuid}/products/${uuid}`, data, config);
};

export const deleteProduct = (orgUuid, uuid, config) => {
  return apiClient.delete(`organizations/${orgUuid}/products/${uuid}`, config);
};

export const getProduct = (orgUuid, uuid, config) => {
  return apiClient.get(u`organizations/${orgUuid}/products/${uuid}`, config);
};

export const getProducts = (orgUuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/products`, config);
};
