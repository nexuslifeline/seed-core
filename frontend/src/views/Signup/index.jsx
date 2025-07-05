import SignupForm from '@components/Sections/Signup';
import Panel from '@components/Panels';
import LeftPane from '@components/Sections/Signup/components/LeftPane';
import { Fragment } from 'react';

export const Signup = () => {
  return (
    <Fragment>
      <LeftPane />
      <Panel>
        <SignupForm />
      </Panel>
    </Fragment>
  );
};

export default Signup;
