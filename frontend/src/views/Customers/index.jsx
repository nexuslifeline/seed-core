import withAuth from '@shared/hoc/withAuth';
import { useMemo, useState, useCallback, useRef } from 'react';
import { customers } from '@data/sample/customers';
import Table from '@components/Table';
import TableContainer from '@components/Table/Container';
import ContentView from '@components/ContentView';
import Breadcrumb from '@components/Breadcrumb';
import EditProfile from '@components/Icons/EditProfile';
import Styles from './customers.module.scss';
import { useForm } from 'react-hook-form';
import Button from '@components/Button';

import Close from '@components/Actions/Panel/Close';

const Customers = (props) => {
  const { register, handleSubmit, setValue, reset } = useForm({
    defaultValues: {
      title: '',
      firstname: '',
      middlename: '',
      lastname: '',
      company: '',
      displayname: '',
      email: '',
      phone: '',
      mobile: '',
      fax: '',
      other: '',
      website: '',
      bstreet: '',
      bcitytown: '',
      bstateprovince: '',
      bpostal: '',
      bcountry: '',
      sstreet: '',
      scitytown: '',
      sstateprovince: '',
      spostal: '',
      scountry: '',
      isactive: ''
    }
  });

  const columns = useMemo(
    () => [
      {
        Header: 'ID #',
        accessor: 'id', // accessor is the "key" in the data
        thStyle: { width: '10%' }
      },
      {
        Header: 'Customer',
        accessor: 'firstname', // accessor is the "key" in the data
        thStyle: { width: '20%' },
        Cell: ({ cell: { row } }) => (
          <>
            <div>
              {row?.original?.title} {row?.original?.firstname}{' '}
              {row?.original?.middlename} {row?.original?.lastname}
            </div>
          </>
        )
      },
      {
        Header: 'Address',
        accessor: 'bstreet',
        thStyle: { width: '50%' },
        Cell: ({ cell: { row } }) => (
          <>
            <div>
              {row?.original?.bstreet} {row?.original?.bcitytown}{' '}
              {row?.original?.bstateprovince} {row?.original?.bpostal}
            </div>
          </>
        )
      },
      {
        Header: 'Company',
        accessor: 'company',
        thStyle: { width: '20%' }
      },
      {
        Header: 'Action',
        accessor: 'action',
        thStyle: { width: '80px', minWidth: '80px' },
        Cell: ({ row }) => (
          <button
            onClick={() => {
              Object.keys(row.original).forEach((key) => {
                setValue(key, row.original[key]);
              });
              setIsModalOpen(true);
            }}
            style={{
              display: 'flex',
              justifyContent: 'center',
              alignItems: 'center'
            }}>
            <EditProfile
              style={{ width: '24px', height: '24px', fill: 'white' }}
            />
          </button>
        )
      }
    ],
    [setValue]
  );

  const [isLoading, setIsLoading] = useState(false);
  const [tableData, setTableData] = useState([]);

  const [pageCount, setPageCount] = useState(13);
  const fetchIdRef = useRef(0);

  const fetchData = useCallback(({ pageIndex, pageSize }) => {
    //mock fetching from server
    const fetchId = ++fetchIdRef.current;
    setIsLoading(true);
    setTimeout(() => {
      if (fetchId === fetchIdRef.current) {
        const startRow = pageSize * pageIndex;
        const endRow = startRow + pageSize;

        setTableData(customers.slice(startRow, endRow));
        setPageCount(Math.ceil(customers.length / pageSize));
        setIsLoading(false);
      }
    }, 500);
  }, []);

  const [isModalOpen, setIsModalOpen] = useState(false);

  const openModal = () => {
    setIsModalOpen(true);
  };

  const closeModal = () => {
    setIsModalOpen(false);
    reset();
  };

  const Modal = ({ isOpen, onClose, children }) => {
    const modalStyles = {
      position: 'fixed',
      top: 0,
      left: 0,
      width: '100%',
      height: '100%',
      background: 'rgba(0, 0, 0, 0.5)',
      display: isOpen ? 'flex' : 'none',
      justifyContent: 'center',
      alignItems: 'center',
      zIndex: 9999
    };

    return (
      <div style={modalStyles} onClick={onClose}>
        <div className={Styles.content} onClick={(e) => e.stopPropagation()}>
          {children}
        </div>
      </div>
    );
  };

  return (
    <ContentView>
      <Breadcrumb
        title={'Manage Customers'}
        items={[
          { text: 'Workspace', to: '/dashboard' },
          { text: 'Customers', to: '/Customers' }
        ]}
      />

      <Modal isOpen={isModalOpen} onClose={closeModal}>
        <div className={Styles.container}>
          {/* <h2>Customer Information</h2>
          <p>Fill in all informations.</p> */}

          <div className={Styles.containerLR}>
            <Close onClick={closeModal} />
          </div>

          <form
            onSubmit={handleSubmit((data) => {
              console.log(data);
            })}>
            <div className={Styles.formboldformtitle}>
              <h2 className=''>Customer Information</h2>
              <p>Fill in all informations.</p>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumnsmall}>
                <div>
                  <label>Title</label>
                  <input {...register('title')} id='title' />
                </div>
              </div>
              <div className={Styles.linecolumn}>
                <div>
                  <label>First name</label>
                  <input {...register('firstname')} id='firstname' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Middle name</label>
                  <input {...register('middlename')} id='middlename' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Last name</label>
                  <input {...register('lastname')} id='lastname' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Display Name</label>
                  <input {...register('displayname')} id='displayname' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Company</label>
                  <input {...register('company')} id='company' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Email</label>
                  <input {...register('email')} id='email' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Phone Number</label>
                  <input {...register('phone')} id='phone' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Fax</label>
                  <input {...register('fax')} id='fax' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Mobile Number</label>
                  <input {...register('mobile')} id='mobile' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Other</label>
                  <input {...register('other')} id='other' />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <label>Website</label>
                  <input {...register('website')} id='website' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Billing Address</label>
                  <input {...register('bstreet')} id='bstreet' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('bcitytown')}
                    id='bcitytown'
                    placeholder='City/Town'
                  />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('bstateprovince')}
                    id='bstateprovince'
                    placeholder='State/Province'
                  />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('bpostal')}
                    id='bpostal'
                    placeholder='Postal code'
                  />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('bcountry')}
                    id='bcountry'
                    placeholder='Country'
                  />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <label>Shipping Address</label>
                  <input {...register('sstreet')} id='sstreet' />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('scitytown')}
                    id='scitytown'
                    placeholder='City/Town'
                  />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('sstateprovince')}
                    id='sstateprovince'
                    placeholder='State/Province'
                  />
                </div>
              </div>
            </div>

            <div className={Styles.linecontainer}>
              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('spostal')}
                    id='spostal'
                    placeholder='Postal code'
                  />
                </div>
              </div>

              <div className={Styles.linecolumn}>
                <div>
                  <input
                    {...register('scountry')}
                    id='scountry'
                    placeholder='Country'
                  />
                </div>
              </div>
            </div>

            <div className={Styles.containerLR}>
              <div>
                <Button className={Styles.rightmargi} onClick={closeModal}>
                  Cancel
                </Button>
                <Button>Make inactive</Button>
              </div>
              <Button type='submit'>Save</Button>
            </div>
          </form>
        </div>
      </Modal>

      <TableContainer title={'Customer'} description={'Customer Information'}>
        <Table
          columns={columns}
          data={tableData}
          isLoading={isLoading}
          pageCount={pageCount}
          fetchData={fetchData}
          showFilter={true}
          // openModal={openModal}
        />
      </TableContainer>
    </ContentView>
  );
};

export default withAuth(Customers);
