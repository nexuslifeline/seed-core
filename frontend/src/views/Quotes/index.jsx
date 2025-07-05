import withAuth from '@shared/hoc/withAuth';

const Quotes = (props) => {
  return <div style={{ padding: '30px' }}>This is the Quotes</div>;
};

export default withAuth(Quotes);
