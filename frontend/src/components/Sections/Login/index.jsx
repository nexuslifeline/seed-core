import { useState } from 'react';
import classNames from 'classnames';
import { useNavigate } from 'react-router-dom';

import Button from '@components/Button';
import UnderlinedText from '@components/UnderlinedText';
import InputContainer from '@components/Form/InputContainer';
import PasswordInput from '@components/Form/PasswordInput';
import TextInput from '@components/Form/TextInput';
import Toggle from '@components/Form/Toggle';
import IconFacebook from '@components/Icons/Facebook';
import IconGoogle from '@components/Icons/Google';
import Welcome from '@components/Sections/Welcome';
import Form from '@components/Form';
import useAuthMutation from '@query/auth';
import { useAuthStore } from '@store/auth';
import Token from '@lib/token';

import Styles from './Login.module.scss';

const LoginForm = () => {
  const navigate = useNavigate();
  const { authenticate, isPending: isLoading } = useAuthMutation();

  const { acceptAuth } = useAuthStore();

  // const [email, setEmail] = useState('');
  // const [password, setPassword] = useState('');

  const handleSubmit = ({ email, password }) =>
    authenticate(
      { email, password },
      {
        onSuccess: ({ data: { user, token } = {} } = {}) => {
          // Store token to local storage
          Token.set(token);
          // Store user data in global state
          acceptAuth(user);
          // redirect to dashboard
          setTimeout(() => navigate('/dashboard'), 500);
        },
        onError: () => {
          alert('Error');
        }
      }
    );

  return (
    <div className={Styles.container}>
      <Welcome
        title={'Welcome Back'}
        description={
          'Enter your Seed Platform credentials and start growing your business.'
        }
      />
      <Form onSubmit={handleSubmit}>
        <Form.FieldGroup label={'Email'}>
          <Form.TextInput name='email' rule={{ required: true }} />
        </Form.FieldGroup>
        <Form.FieldGroup label={'Password'}>
          <Form.Password name='password' rule={{ required: true }} />
        </Form.FieldGroup>
        <div className={Styles.row}>
          <Toggle label={'Remember Me'} />
          <button className={classNames(Styles.link, Styles.forgotLink)}>
            {'Forgot password?'}
          </button>
        </div>
        <div className={Styles.actionsContainer}>
          <Button type={'submit'} isBusy={isLoading} block>{`Sign in`}</Button>
          <Button
            type={'button'}
            variant={Button.Variants.SECONDARY_OUTLINE}
            block>
            <IconGoogle className={Styles.icon} />
            {`Sign in with Google`}
          </Button>
          <Button
            type={'button'}
            variant={Button.Variants.SECONDARY_OUTLINE}
            block>
            <IconFacebook className={Styles.icon} />
            {`Sign in with Facebook`}
          </Button>
        </div>
      </Form>
      <div>
        {`Don't have an account?`}
        <button
          className={classNames(Styles.link, Styles.signupLink)}
          onClick={() => navigate('/signup')}>
          <UnderlinedText>{'Signup for free'}</UnderlinedText>
        </button>
      </div>
    </div>
  );
};

export default LoginForm;
