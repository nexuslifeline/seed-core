import { PageTransition } from '@steveeeie/react-page-transition';
import { useLocation } from 'react-router-dom';

const withTransition = (Component) => (props) => {
  const { pathname } = useLocation();
  return (
    <PageTransition preset='moveToLeftFromRight' transitionKey={pathname}>
      <Component {...props} />
    </PageTransition>
  );
};

export default withTransition;
