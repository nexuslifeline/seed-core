import apiClient from '@api/apiClient';

export const postCustomer = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/customers`, data, config);
};

export const putCustomer = (orgUuid, uuid, data, config) => {
  return apiClient.put(`organizations/${orgUuid}/customers/${uuid}`, data, config);
};

export const patchCustomer = (orgUuid, uuid, data, config) => {
  return apiClient.patch(`organizations/${orgUuid}/customers/${uuid}`, data, config);
};

export const deleteCustomer = (orgUuid, uuid, config) => {
  return apiClient.delete(`organizations/${orgUuid}/customers/${uuid}`, config);
};

export const getCustomer = (orgUuid, uuid, config) => {
  return apiClient.get(u`organizations/${orgUuid}/customers/${uuid}`, config);
};

export const getCustomers = (orgUuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/customers`, config);
};
