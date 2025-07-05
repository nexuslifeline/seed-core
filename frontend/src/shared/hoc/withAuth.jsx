import { ProtectedRoute } from '@router/ProtectedRoute';

const withAuth = (Component) => (props) => {
  return (
    <ProtectedRoute>
      <Component {...props} />
    </ProtectedRoute>
  );
};

export default withAuth;
