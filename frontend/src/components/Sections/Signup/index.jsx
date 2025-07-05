import Button from '@components/Button';
import UnderlinedText from '@components/UnderlinedText';
import InputContainer from '@components/Form/InputContainer';
import PasswordInput from '@components/Form/PasswordInput';
import TextInput from '@components/Form/TextInput';
import IconFacebook from '@components/Icons/Facebook';
import IconGoogle from '@components/Icons/Google';
import Welcome from '@components/Sections/Welcome';
import Styles from './Signup.module.scss';
import { useNavigate } from 'react-router-dom';
import classNames from 'classnames';
import InputGroup from '@components/Form/InputGroup';

const Signup = () => {
  const navigate = useNavigate();
  return (
    <div className={Styles.container}>
      <Welcome
        title={'Create an account'}
        description={'Create your account and have a full featured access for free. No credit card required.'}
      />
      <InputContainer>
        <TextInput label='Name' placeholder='Name' />
      </InputContainer>
      <InputContainer>
        <TextInput label='Email' placeholder='Email' />
      </InputContainer>
      <InputGroup>
        <InputContainer>
          <PasswordInput label='Password' placeholder='Password' />
        </InputContainer>
        <InputContainer>
          <PasswordInput label='Confirm Password' placeholder='Confirm Password' />
        </InputContainer>
      </InputGroup>
      <div className={Styles.actionsContainer}>
        <Button block>{`Create account`}</Button>
        <Button variant={Button.Variants.SECONDARY_OUTLINE} block>
          <IconGoogle className={Styles.icon} />
          {`Sign up with Google`}
        </Button>
        <Button variant={Button.Variants.SECONDARY_OUTLINE} block>
          <IconFacebook className={Styles.icon} />
          {`Sign up with Facebook`}
        </Button>
      </div>
      <div>
        {`Already have an account?`}
        <button className={classNames(Styles.link, Styles.login)} onClick={() => navigate('/')}>
          <UnderlinedText>{'Sign in'}</UnderlinedText>
        </button>
      </div>
    </div>
  );
};

export default Signup;
