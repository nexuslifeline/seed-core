import withAuth from '@shared/hoc/withAuth';

const Account = (props) => {
  return <div style={{ padding: '30px' }}>This is the Account</div>;
};

export default withAuth(Account);
