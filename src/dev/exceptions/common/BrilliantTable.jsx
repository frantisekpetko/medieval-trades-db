import React from 'react';

import classNames from 'classnames';
import PropTypes from 'prop-types';
import { withStyles } from '@material-ui/core/styles/index';
import Table from '@material-ui/core/Table/index';
import TableBody from '@material-ui/core/TableBody/index';
import TableCell from '@material-ui/core/TableCell/index';
import TableHead from '@material-ui/core/TableHead/index';
import TablePagination from '@material-ui/core/TablePagination/index';
import TableRow from '@material-ui/core/TableRow/index';
import TableSortLabel from '@material-ui/core/TableSortLabel/index';
import Toolbar from '@material-ui/core/Toolbar/index';
import Typography from '@material-ui/core/Typography/index';
import Paper from '@material-ui/core/Paper/index';
import Checkbox from '@material-ui/core/Checkbox/index';
import IconButton from '@material-ui/core/IconButton/index';
import Tooltip from '@material-ui/core/Tooltip/index';
import DeleteIcon from '@material-ui/icons/Delete';
import FilterListIcon from '@material-ui/icons/FilterList';
import { lighten } from '@material-ui/core/styles/colorManipulator';


let counter = 0;
function createData(type, message, stack_trace, created_at) {
    counter += 1;
    return { id: counter, counter, type, message, stack_trace, created_at };
}

function desc(a, b, orderBy) {
    if (b[orderBy] < a[orderBy]) {
        return -1;
    }
    if (b[orderBy] > a[orderBy]) {
        return 1;
    }
    return 0;
}

function stableSort(array, cmp) {
    const stabilizedThis = array.map((el, index) => [el, index]);
    stabilizedThis.sort((a, b) => {
        const order = cmp(a[0], b[0]);
        if (order !== 0) return order;
        return a[1] - b[1];
    });
    return stabilizedThis.map(el => el[0]);
}

function getSorting(order, orderBy) {
    return order === 'desc' ? (a, b) => desc(a, b, orderBy) : (a, b) => -desc(a, b, orderBy);
}

const rows = [
    { id: 'id', numeric: true, disablePadding: false, label: 'ID' },
    { id: 'type', numeric: false, disablePadding: false, label: 'Type' },
    { id: 'message', numeric: false, disablePadding: true, label: 'Message' },
    { id: 'stack_trace', numeric: false, disablePadding: false, label: 'Stack Trace' },
    { id: 'created_at', numeric: false, disablePadding: true, label: 'Created At' }
];

class BrilliantTableHead extends React.Component {
    createSortHandler = property => event => {
        this.props.onRequestSort(event, property);
    };

    render() {
        const { onSelectAllClick, order, orderBy, numSelected, rowCount } = this.props;

        return <TableHead>
            <TableRow>
                <TableCell padding="checkbox">
                    <Checkbox
                        indeterminate={numSelected > 0 && numSelected < rowCount}
                        checked={numSelected === rowCount}
                        onChange={onSelectAllClick}
                    />
                </TableCell>
                {rows.map(
                    row => (
                        <TableCell
                            key={row.id}
                            align={row.numeric ? 'right' : 'left'}
                            padding={row.disablePadding ? 'none' : 'default'}
                            sortDirection={orderBy === row.id ? order : false}
                        >
                            <Tooltip
                                title="Sort"
                                placement={row.numeric ? 'bottom-end' : 'bottom-start'}
                                enterDelay={300}
                            >
                                <TableSortLabel
                                    active={orderBy === row.id}
                                    direction={order}
                                    onClick={this.createSortHandler(row.id)}
                                >
                                    {row.label}
                                </TableSortLabel>
                            </Tooltip>
                        </TableCell>
                    ),
                    this,
                )}
            </TableRow>
        </TableHead>;
    }
}

BrilliantTableHead.propTypes = {
    numSelected: PropTypes.number.isRequired,
    onRequestSort: PropTypes.func.isRequired,
    onSelectAllClick: PropTypes.func.isRequired,
    order: PropTypes.string.isRequired,
    orderBy: PropTypes.string.isRequired,
    rowCount: PropTypes.number.isRequired,
};

const toolbarStyles = theme => ({
    root: {
        paddingRight: theme.spacing.unit,
        marginTop: "1rem"
    },
    highlight:
        theme.palette.type === 'light'
            ? {
                color: theme.palette.secondary.main,
                backgroundColor: lighten(theme.palette.secondary.light, 0.85),
            }
            : {
                color: theme.palette.text.primary,
                backgroundColor: theme.palette.secondary.dark,
            },
    spacer: {
        flex: '1 1 100%',
    },
    actions: {
        color: theme.palette.text.secondary,
    },
    title: {
        flex: '0 0 auto',
    },
});

let BrilliantTableToolbar = props => {
    const { numSelected, classes } = props;

    return (
        <Toolbar
            className={classNames(classes.root, {
                [classes.highlight]: numSelected > 0,
            })}
        >
            <div className={classes.title}>
                {numSelected > 0 ? (
                    <Typography color="inherit" variant="subtitle1">
                        {numSelected} selected
                    </Typography>
                ) : (
                    <Typography variant="h6" id="tableTitle">
                        {props.name}
                    </Typography>
                )}
            </div>
            <div className={classes.spacer} />
            <div className={classes.actions}>
                {numSelected > 0 ? (
                    <Tooltip title="Delete">
                        <IconButton aria-label="Delete">
                            <DeleteIcon />
                        </IconButton>
                    </Tooltip>
                ) : (
                    <Tooltip title="Filter list">
                        <IconButton aria-label="Filter list">
                            <FilterListIcon />
                        </IconButton>
                    </Tooltip>
                )}
            </div>
        </Toolbar>
    );
};

BrilliantTableToolbar.propTypes = {
    classes: PropTypes.object.isRequired,
    numSelected: PropTypes.number.isRequired,
};

BrilliantTableToolbar = withStyles(toolbarStyles)(BrilliantTableToolbar);

const styles = theme => ({
    root: {
        width: '60%',
        marginTop: "1rem",
    },
    table: {
        maxWidth: 1000,
    },
    tableWrapper: {
        overflowX: 'auto',
    },
});

class BrilliantTable extends React.PureComponent {
    state = {
        order: 'asc',
        orderBy: 'ID',
        selected: [   ],
        data: [],
        page: 0,
        rowsPerPage: 5,
    };

    componentWillReceiveProps(nextProps) {
        if (this.props.log !== nextProps.log) {
            console.log("errors", nextProps.log);
            this.updateData(nextProps.log);
        }
    }


    updateData = (data) => {
        console.log("updateData", data);
        data[0].map((err, index) => {
            console.log("xxx", index, err.stack_trace);
            if (this.state.data.length !== 0 ) {
                this.setState({data: [...this.state.data, Object.assign(createData(
                        err.type, err.message, err.stack_trace, err.created_at
                    ))]});
            }
            else{
                this.setState({data: [Object.assign(createData(
                        err.type, err.message, err.stack_trace, err.created_at
                    ))]});
            }
        })
    };



    handleRequestSort = (event, property) => {
        const orderBy = property;
        let order = 'desc';

        if (this.state.orderBy === property && this.state.order === 'desc') {
            order = 'asc';
        }

        this.setState({ order, orderBy });
    };

    handleSelectAllClick = event => {
        if (event.target.checked) {
            this.setState(state => ({ selected: state.data.map(n => n.id) }));
            return;
        }
        this.setState({ selected: [] });
    };

    handleClick = (event, id) => {
        const { selected } = this.state;
        const selectedIndex = selected.indexOf(id);
        let newSelected = [];

        if (selectedIndex === -1) {
            newSelected = newSelected.concat(selected, id);
        } else if (selectedIndex === 0) {
            newSelected = newSelected.concat(selected.slice(1));
        } else if (selectedIndex === selected.length - 1) {
            newSelected = newSelected.concat(selected.slice(0, -1));
        } else if (selectedIndex > 0) {
            newSelected = newSelected.concat(
                selected.slice(0, selectedIndex),
                selected.slice(selectedIndex + 1),
            );
        }

        this.setState({ selected: newSelected });
    };

    handleChangePage = (event, page) => {
        this.setState({ page });
    };

    handleChangeRowsPerPage = event => {
        this.setState({ rowsPerPage: event.target.value });
    };

    isSelected = id => this.state.selected.indexOf(id) !== -1;

    render() {
        const { classes } = this.props;
        const { data, order, orderBy, selected, rowsPerPage, page } = this.state;
        const emptyRows = rowsPerPage - Math.min(rowsPerPage, data.length - page * rowsPerPage);

        return (
            <Paper className={classes.root}>
                <BrilliantTableToolbar numSelected={selected.length} name={this.props.name} classes={null}/>
                <div className={classes.tableWrapper}>
                    <Table className={classes.table} aria-labelledby="tableTitle">
                        <BrilliantTableHead
                            numSelected={selected.length}
                            order={order}
                            orderBy={orderBy}
                            onSelectAllClick={this.handleSelectAllClick}
                            onRequestSort={this.handleRequestSort}
                            rowCount={data.length}
                        />
                        <TableBody>
                            {stableSort(data, getSorting(order, orderBy))
                                .slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)
                                .map(n => {
                                    const isSelected = this.isSelected(n.id);
                                    return (
                                        <TableRow
                                            hover
                                            onClick={event => this.handleClick(event, n.id)}
                                            role="checkbox"
                                            aria-checked={isSelected}
                                            tabIndex={-1}
                                            key={n.id}
                                            selected={isSelected}
                                        >
                                            <TableCell padding="checkbox">
                                                <Checkbox checked={isSelected} />
                                            </TableCell>
                                            <TableCell component="th" scope="row" padding="none">
                                                {n.name}
                                            </TableCell>
                                            <TableCell className="right-align">{n.id}</TableCell>
                                            <TableCell className="right-align" >{n.type}</TableCell>
                                            <TableCell className="right-align">{n.message}</TableCell>
                                            <TableCell className="right-align"><details>{n.stack_trace}</details></TableCell>
                                            <TableCell className="right-align" >{n.created_at}</TableCell>
                                        </TableRow>
                                    );
                                })}
                            {emptyRows > 0 && (
                                <TableRow style={{ height: 49 * emptyRows }}>
                                    <TableCell colSpan={6} />
                                </TableRow>
                            )}
                        </TableBody>
                    </Table>
                </div>
                <TablePagination
                    rowsPerPageOptions={[5, 10, 25]}
                    component="div"
                    count={data.length}
                    rowsPerPage={rowsPerPage}
                    page={page}
                    backIconButtonProps={{
                        'aria-label': 'Previous Page',
                    }}
                    nextIconButtonProps={{
                        'aria-label': 'Next Page',
                    }}
                    onChangePage={this.handleChangePage}
                    onChangeRowsPerPage={this.handleChangeRowsPerPage}
                />
            </Paper>
        );
    }
}

BrilliantTable.propTypes = {
    classes: PropTypes.object.isRequired,
};

export default withStyles(styles)(BrilliantTable);