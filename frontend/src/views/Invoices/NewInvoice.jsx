import Breadcrumb from '@components/Breadcrumb';
import Card from '@components/Card';
import ContentView from '@components/ContentView';
import TextInput from '@components/Form/TextInput';
import TextArea from '@components/Form/TextArea';
import InputContainer from '@components/Form/InputContainer';
import InputGroup from '@components/Form/InputGroup';
import Form from '@components/Form';
import Button from '@components/Button';

export const NewInvoice = () => {
  const options = [
    { value: 'chocolate', label: 'Chocolate' },
    { value: 'strawberry', label: 'Strawberry' },
    { value: 'vanilla', label: 'Vanilla' }
  ];

  const onSubmit = (data) => console.log(data);
  return (
    <ContentView>
      {' '}
      <Breadcrumb
        title={'New Invoice'}
        items={[
          { text: 'Workspace', to: '/dashboard' },
          { text: 'Invoices', to: '/invoices' }
        ]}
      />
      <Card header={'Invoice'} maxWidth={800}>
        <Form onSubmit={onSubmit} defaultValues={{ amount: 7, phone: 1232323 }}>
          <Form.FieldGroup label='Password'>
            <Form.Password
              name='password'
              rule={{ required: true, minLength: 6, maxLength: 20 }}
            />
          </Form.FieldGroup>

          <Form.TextInput
            name='date'
            label='Date'
            rule={{ required: true, minLength: 5, maxLength: 10 }}
          />
          <Form.TextInput
            name='amount'
            label='Amount'
            type='number'
            rule={{ min: 1, max: 10, required: true }}
          />
          <Form.TextArea
            name='note'
            label='Description'
            rule={{ required: true }}
          />

          <Form.PhoneNumber
            name='phone'
            label='Phone Number'
            rule={{ required: true }}
          />
          <Form.Select
            name='customer'
            rule={{ required: true }}
            options={options}
            isClearable
          />

          <br />
          <br />
          <Button type='submit'>Test Submit</Button>
        </Form>

        <InputGroup>
          <InputContainer></InputContainer>
          <InputContainer>
            <TextInput label='Due Date' />
          </InputContainer>
        </InputGroup>
        <InputContainer>
          <TextArea />
        </InputContainer>
      </Card>
    </ContentView>
  );
};

export default NewInvoice;
