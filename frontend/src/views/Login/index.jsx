import LoginForm from '@components/Sections/Login';
import Panel from '@components/Panels';
import RightPane from '@components/Sections/Login/components/RightPane';
import { Fragment } from 'react';

export const Login = () => {
  return (
    <Fragment>
      <Panel>
        <LoginForm />
      </Panel>
      <RightPane />
    </Fragment>
  );
};

export default Login;
