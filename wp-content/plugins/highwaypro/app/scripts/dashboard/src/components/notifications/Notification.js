import './Notification.css';

import Button from '@material-ui/core/Button';
import Close from '@material-ui/icons/Close';
import Dialog from  '@material-ui/core/Dialog';
import DialogActions from  '@material-ui/core/DialogActions';
import DialogContent from  '@material-ui/core/DialogContent';
import DialogContentText from  '@material-ui/core/DialogContentText';
import DialogTitle from  '@material-ui/core/DialogTitle';
import IconButton from  '@material-ui/core/IconButton';
import React, {Component} from 'react';
import Snackbar from  '@material-ui/core/Snackbar';

import { HighWayPro } from '../../domain/highwaypro/HighWayPro';
import { Strings as S, Strings } from '../../domain/utilities/Strings';
import Debug from './Debug';

class Notification extends Component {
    state = {
        moreInfoIsOpened: false
    }

    handleClose = (argument) => 
    {
        this.props.whenClose && this.props.whenClose();
    }

    openOrCloseMoreInfo = (openOrClose) => {
        this.setState({
            moreInfoIsOpened: (openOrClose === 'open')
        });
    }

    render() {
        const messageObject = this.props.messageObject;
        const hasMessageObject = messageObject;
        const canBeClosed = typeof this.props.whenClose === 'function';
        
        return (    
        <div className={`hp-notification ${this.props.className} --${this.props.type}`}>
            <Snackbar
                  className="hp-notification-container"
                  anchorOrigin={{
                    vertical: 'bottom',
                    horizontal: 'left',
                  }}
                  open={this.props.open}
                  autoHideDuration={this.props.type === 'success'? (8 * 1000) : null}
                  onClose={this.handleClose}
                  ContentProps={{
                    'aria-describedby': 'message-id',
                  }}
                  message={<div>{S.explodeByNewLine(this.props.message || '').map(line => (<p>{line}</p>))}</div>}
                  action={[
                    (hasMessageObject? (<Button onClick={this.openOrCloseMoreInfo.bind(this, 'open')} key="undo" color="secondary" size="small">
                                          More Info
                                        </Button>): null),
                    (canBeClosed? (<IconButton
                                      key="close"
                                      aria-label="Close"
                                      color="inherit"
                                      onClick={this.props.whenClose}
                                    >
                                      <Close />
                                    </IconButton>) : null),
                  ]}
            />
            {hasMessageObject && (
                <Dialog
                  open={this.state.moreInfoIsOpened}
                  onClose={this.handleClose}
                  aria-labelledby="scroll-dialog-title"
                >
                    <DialogTitle id="scroll-dialog-title">{HighWayPro.text.other.details[messageObject.state] || HighWayPro.text.other.details.general}</DialogTitle>
                        <DialogContent>
                            <DialogContentText>
                                <p className="hp-more-info-message">{messageObject.message}</p>
                                <p className="hp-more-info-type">{messageObject.type}</p>
                                <Debug object={messageObject._client} />
                            </DialogContentText>
                        </DialogContent>
                    <DialogActions>
                        <Button onClick={this.openOrCloseMoreInfo.bind(this, 'close')} color="primary">
                          Cancel
                        </Button>
                    </DialogActions>
                </Dialog>
            )}
        </div>
        );
    }
}

export default Notification;