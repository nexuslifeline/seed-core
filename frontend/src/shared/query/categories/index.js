import { useMutation, useQuery } from '@tanstack/react-query';
import { postCategory, getCategories } from '@shared/api/categories';

export const usePostCategoryMutation = (orgUuid, options = {}) => {
  const { mutate, ...rest } = useMutation({
    mutationFn: (data) => postCategory(orgUuid, data),
    ...options
  });

  return { authenticate: mutate, ...rest };
};

export const useCategoriesQuery = (orgUuid, params) => {
  const { data: { data: { data = [], meta = {} } = {} } = {}, ...rest } =
    useQuery({
      queryKey: ['categories', params],
      queryFn: () => getCategories(orgUuid, params),
      keepPreviousData: true
    });

  return { categories: data, meta, ...rest };
};
