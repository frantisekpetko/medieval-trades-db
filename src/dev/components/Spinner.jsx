import React from 'react';
import Grid from '@material-ui/core/Grid';

const Spinner = () => (
  <div>
      <Grid
          container
          direction="column"
          justify="center"
          alignItems="center"
      >
          <div className="spinner-container">
              <div className="spinner">{"           "}</div>
          </div>
      </Grid>
  </div>
);

export default Spinner;