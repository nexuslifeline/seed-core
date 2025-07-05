import { useMutation } from '@tanstack/react-query';
import { loginUser } from '@shared/api/auth';

const useAuthMutation = (options = {}) => {
  const { mutate, ...rest } = useMutation({
    mutationFn: loginUser,
    ...options
  });

  return { authenticate: mutate, ...rest };
};

export default useAuthMutation;
