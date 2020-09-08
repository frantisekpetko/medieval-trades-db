import React from 'react';
import Typography from '@material-ui/core/Typography';
import Card from '@material-ui/core/Card';
import CardActions from '@material-ui/core/CardActions';
import CardContent from '@material-ui/core/CardContent';
import Button from '@material-ui/core/Button';
import Grid from '@material-ui/core/Grid';
import { Link } from 'react-router-dom';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import { faChevronRight } from '@fortawesome/free-solid-svg-icons';
import { library } from '@fortawesome/fontawesome-svg-core';
import { fab } from '@fortawesome/free-brands-svg-icons';

library.add(fab, faChevronRight);

const Content = () => (
    <Grid container spacing={10} style={{ paddingLeft: 200, paddingTop: 25 }}>
        <Grid item xs={12} sm={12} lg={6} xl={3} className="pb-3-5">
            <Card className="card">
                <CardContent>
                    <Typography className="bold" variant="subtitle1" gutterBottom component="h2">
                        Entity Generator
                    </Typography>
                    <Typography component="p">
                        Description.
                        <br />
                        <i>
                            This generator allows to generate schema of data in given table as entity in database, or generate Active-Record class having
                            CRUD database to current entity with generated data schema.
                        </i>
                    </Typography>
                </CardContent>
                <CardActions>
                    <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                        <Button to="/dev/entity" component={Link} variant="contained" size="small">
                            Begin
                            <FontAwesomeIcon className="text-and-icon-space" icon="chevron-right" />
                        </Button>
                    </Grid>
                </CardActions>
            </Card>
        </Grid>
        <Grid  item xs={12} sm={12} lg={6} xl={3} >
            <Card className="card">
                <CardContent className="pb-3-5">
                    <Typography className="bold" variant="subtitle1" gutterBottom component="h2">
                        Relationship Generator
                    </Typography>
                    <Typography component="p">
                        Description.
                        <br />
                        <i>
                            This generator generates a relationships between entities/tables, after generating common entities, and helps you assemble
                            your database together.
                        </i>
                    </Typography>
                </CardContent>
                <CardActions>
                    <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                        <Button to="/dev/relationship" component={Link} variant="contained" size="small">
                            Begin
                            <FontAwesomeIcon className="text-and-icon-space" icon="chevron-right" />
                        </Button>
                    </Grid>
                </CardActions>
            </Card>
        </Grid>
        <Grid  item xs={12} sm={12} lg={6} xl={3}  className="pb-3-5">
            <Card className="card">
                <CardContent>
                    <Typography className="bold" gutterBottom variant="subtitle1" component="h2">
                        Route Generator
                    </Typography>
                    <Typography component="p">
                        Description.
                        <br />
                        <i>This generator helps you quickly generate a new route collection corresponding with your CRUD and API.</i>
                    </Typography>
                </CardContent>
                <CardActions>
                    <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                        <Button to="/dev/routing" component={Link} variant="contained" size="small">
                            Begin
                            <FontAwesomeIcon className="text-and-icon-space" icon="chevron-right" />
                        </Button>
                    </Grid>
                </CardActions>
            </Card>
        </Grid>
        <Grid item xs={12} sm={12} lg={6} xl={3}  className="pb-3-5">
            <Card className="card">
                <CardContent>
                    <Typography className="bold" gutterBottom variant="subtitle1" component="h2">
                        Database Assistant
                    </Typography>
                    <Typography component="p">
                        Description.
                        <br />
                        <i>
                            This generator/assistant helps you with routine tasks at database, like seeding data to database, cleaning up and removing
                            data from database and re-creating of database schema.
                        </i>
                    </Typography>
                </CardContent>
                <CardActions>
                    <Grid container direction="row" justify="flex-end" alignItems="flex-end">
                        <Button to="/dev/db-assistant" component={Link} variant="contained" size="small">
                            Begin
                            <FontAwesomeIcon className="text-and-icon-space" icon="chevron-right" />
                        </Button>
                    </Grid>
                </CardActions>
            </Card>
        </Grid>
    </Grid>
);

export default Content;
