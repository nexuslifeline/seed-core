import apiClient from '@api/apiClient';

export const postCategory = (orgUuid, data, config) => {
  return apiClient.post(`organizations/${orgUuid}/categories`, data, config);
};

export const putCategory = (orgUuid, uuid, data, config) => {
  return apiClient.put(
    `organizations/${orgUuid}/categories/${uuid}`,
    data,
    config
  );
};

export const patchCategory = (orgUuid, uuid, data, config) => {
  return apiClient.patch(
    `organizations/${orgUuid}/categories/${uuid}`,
    data,
    config
  );
};

export const deleteCategory = (orgUuid, uuid, config) => {
  return apiClient.delete(
    `organizations/${orgUuid}/categories/${uuid}`,
    config
  );
};

export const getCategory = (orgUuid, uuid, config) => {
  return apiClient.get(`organizations/${orgUuid}/categories/${uuid}`, config);
};

export const getCategories = (orgUuid, config) => {
  console.log('getCategories');
  return apiClient.get(`organizations/${orgUuid}/categories`, config);
};
