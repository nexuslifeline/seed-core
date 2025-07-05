import apiClient from '@api/apiClient';

export const postTerm = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/terms`, data, config);
};

export const putTerm = (orgUuid, uuid, data, config) => {
  return apiClient.put(`organizations/${orgUuid}/terms/${uuid}`, data, config);
};

export const patchTerm = (orgUuid, uuid, data, config) => {
  return apiClient.patch(`organizations/${orgUuid}/terms/${uuid}`, data, config);
};

export const deleteTerm = (orgUuid, uuid, config) => {
  return apiClient.delete(`organizations/${orgUuid}/terms/${uuid}`, config);
};

export const getTerm = (orgUuid, uuid, config) => {
  return apiClient.get(u`organizations/${orgUuid}/terms/${uuid}`, config);
};

export const getTerms = (orgUuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/terms`, config);
};
