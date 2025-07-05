import apiClient from '@api/apiClient';

export const postInvoice = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/invoices`, data, config);
};

export const putInvoice = (orgUuid, uuid, data, config) => {
  return apiClient.put(`organizations/${orgUuid}/invoices/${uuid}`, data, config);
};

export const patchInvoice = (orgUuid, uuid, data, config) => {
  return apiClient.patch(`organizations/${orgUuid}/invoices/${uuid}`, data, config);
};

export const deleteInvoice = (orgUuid, uuid, config) => {
  return apiClient.delete(`organizations/${orgUuid}/invoices/${uuid}`, config);
};

export const getInvoice = (orgUuid, uuid, config) => {
  return apiClient.get(u`organizations/${orgUuid}/invoices/${uuid}`, config);
};

export const getInvoices = (orgUuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/invoices`, config);
};
