import apiClient from '@api/apiClient';

export const postUnit = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/units`, data, config);
};

export const putUnit = (orgUuid, uuid, data, config) => {
  return apiClient.put(`organizations/${orgUuid}/units/${uuid}`, data, config);
};

export const patchUnit = (orgUuid, uuid, data, config) => {
  return apiClient.patch(`organizations/${orgUuid}/units/${uuid}`, data, config);
};

export const deleteUnit = (orgUuid, uuid, config) => {
  return apiClient.delete(`organizations/${orgUuid}/units/${uuid}`, config);
};

export const getUnit = (orgUuid, uuid, config) => {
  return apiClient.get(u`organizations/${orgUuid}/units/${uuid}`, config);
};

export const getUnits = (orgUuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/units`, config);
};
